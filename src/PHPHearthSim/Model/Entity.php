<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
namespace PHPHearthSim\Model;

use PHPHearthSim\Exception\Entity\InvalidEventException;

use PHPHearthSim\Model\Player;
use PHPHearthSim\Model\EntityAdjustment;
use PHPHearthSim\Model\Board;
use PHPHearthSim\Event\EntitySubscriber;
use PHPHearthSim\Event\EntityEvent;
use PHPHearthSim\Model\Mechanic\Deathrattle;

use PHPHearthSim\Event\Entity\EntityCreateEvent;
use PHPHearthSim\Event\Entity\EntityDeathrattleEvent;
use PHPHearthSim\Event\Entity\EntityTakeDamageEvent;
use PHPHearthSim\Event\Entity\EntityReceiveHealEvent;
use PHPHearthSim\Event\Entity\EntityGainArmorEvent;
use PHPHearthSim\Event\Entity\EntityRemoveArmorEvent;
/**
 * Main game entity
 * This is the base class in which all other game entites are derived from.
 *
 * @class Entity
 * @property-read \PHPHearthSim\Model\Board $board get the board reference
 * @property-read int $id get the entity unique identifier
 * @property \PHPHearthSim\Model\EntityyAdjustment[] $adjustments set/get entity adjustments
 * @property mixed $lastSignalReceived set/get the last signal received
 * @property-read string $rarity get entity rarity
 * @property-read string $name get entity name
 * @property-read string $rarity get entity rarity
 * @property-read int $baseCost get entity base cost
 * @property-read int $baseHealth get entity base health
 * @property-read int $baseAttack get entity base attack
 * @property-read int $cost get entity cost
 * @property-read int $health get entity health
 * @property-read int $attack get entity attack
 */
abstract class Entity extends EntityEvents implements EntityInterface {

    /**
     * Basic rarity
     *
     * @var string
     */
    const RARITY_COMMON = 'Common';

    /**
     * Basic rarity
     *
     * @var string
     */
    const RARITY_RARE = 'Rare';


    /**
     * Unique rarity
     *
     * @var string
     */
    const RARITY_UNIQUE = 'Unique';

    /**
     * Reference to the game board (for events)
     *
     * @var \PHPHearthSim\Model\Board
     */
    protected $board;


    /**
     * Array of events to listen to (string names defined in EntityEvent::EVENT_XXXX
     *
     * @var array
     */
    protected $listeners = [
        EntityEvent::EVENT_ENTITY_CREATE
    ];

    /**
     * Get owner of entity
     *
     * @var \PHPHearthSim\Model\Player;
     */
    protected $owner;

    /**
     * Unique id that is generated by the board
     *
     * @var string
     */
    protected $id;

    /**
     * List of adjustments made to a entity
     *
     * @var \PHPHearthSim\Model\EntityyAdjustment[]
     */
    protected $adjustments = [];


    /**
     * The last signal that was received by another entity
     * Used mostly for debugging
     *
     * @var mixed
     */
    protected $lastSignalReceived = [
        'signal' => null,
        'event'  => null
    ];

    /**
     * Entity rarity. See Entity::RARITY_ constants
     *
     * @var string
     */
    protected $rarity;

    /**
     * Entity name
     *
     * @var string
     */
    protected $name;

    /**
     * The base cost of a entity (before reduction or penalties from other adjustments)
     *
     * @var int
     */
    protected $baseCost;

    /**
     * The base health of a entity (before reduction or penalties from other adjustments)
     *
     * @var int
     */
    protected $baseHealth;

    /**
     * The base attack of a entity (before reduction or penalties from other adjustments)
     * @var int
     */
    protected $baseAttack;

    /**
     * The current calculated cost of entity (after reduction or penalties from other adjustments)
     *
     * @var int
     */
    protected $cost;

    /**
     * The current calculated attack of entity (after reduction or penalties from other adjustments)
     *
     * @var int
     */
    protected $attack;

    /**
     * The current calculated health of entity (after reduction or penalties from other adjustments)
     *
     * @var int
     */
    protected $health;

    /**
     * Get the traits for entity
     *
     * @var array
     */
    protected $traits;

    /**
     * If unit has been silenced.
     * You can never remove a silence.
     *
     * @var boolean
     */
    protected $silenced = false;

    /**
     * Constructor
     * Allow to set some options like adjustments on initialization
     *
     * @param array $options Options to set during initialization
     */
    public function __construct(array $options = []) {
        parent::__construct();

        // Assign the board
        if (isset($options['board'])) {
            $this->board = $options['board'];
            // Generate a unique id for the entity
            $this->id = $this->board->generateEntityId();
        }

        // Apply adjustments if passed
        if (isset($options['adjustments'])) {
            $this->adjustments = $options['adjustments'];
        }

        // Apply owner of card if provided
        if (isset($options['owner']) && $options['owner'] instanceof Player) {
            $this->owner = $options['owner'];
        }

        // Set up subscription to events
        $this->subscribe();
        // Signal that we were created
        $this->emit(EntityEvent::EVENT_ENTITY_CREATE);
        // Create cache of traits
        $this->traits = class_uses($this);
    }

    /**
     * Get the board reference
     *
     * @return \PHPHearthSim\Model\Board
     */
    public function getBoard() {
        return $this->board;
    }

    /**
     * Set the board reference
     *
     * @param \PHPHearthSim\Model\Board $board
     * @return \PHPHearthSim\Model\Entity
     */
    public function setBoard(Board $board) {
        $this->board = $board;

        return $this;
    }


    /**
     * Set owner (player) of entity
     *
     * @param \PHPHearthSim\Model\Player $owner
     * @return \PHPHearthSim\Model\Entity
     */
    public function setOwner(Player $owner) {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner (player) of entity
     *
     * @return \PHPHearthSim\Model\Player
     */
    public function getOwner() {
        return $this->owner;
    }

    /**
     * Return my hero based on owner value
     *
     * @return \PHPHearthSim\Model\Hero
     */
    public function getHero() {
        // If "me" owns the card, return "me", else return "opponent"
        return ($this->getOwner() == $this->getBoard()->getMe()) ?
            $this->getBoard()->getMe()->getHero() : $this->getBoard()->getOpponent()->getHero();
    }

    /**
     * Return enemy hero based on owner value
     *
     * @return \PHPHearthSim\Model\Hero
     */
    public function getEnemyHero() {
        // If "me" owns the card, return "opponent", else return "me"
        return ($this->getOwner() == $this->getBoard()->getMe()) ?
            $this->getBoard()->getOpponent()->getHero() : $this->getBoard()->getMe()->getHero();
    }

    /**
     * Get the entity unique identifier set by the board
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Create a subscriber for the entity and listen to events
     *
     * @return \PHPHearthSim\Model\Entity
     */
    private function subscribe() {
        // Make sure we have a valid board
        if (!$this->board instanceof Board) {
            return $this;
        }

        // Create entity subscriber for this entity
        $entitySubscriber = new EntitySubscriber();
        $entitySubscriber->setEntity($this);

        // Add the subscriber
        $this->getBoard()->subscribe($entitySubscriber);

        return $this;
    }

    /**
     * See if entity listens to an event
     *
     * @param string $eventName
     * @return boolean
     */
    public function listenTo($eventName) {
        return in_array($eventName, $this->listeners);
    }


    /**
     * Add event listener for event
     *
     * @param string $eventName
     * @return \PHPHearthSim\Model\Entity
     */
    public function addListener($eventName) {
        if (!in_array($eventName, $this->listeners)) {
            $this->listeners[] = $eventName;
        }

        return $this;
    }

    /**
     * Emit a signal to board
     *
     * @param string $eventName
     * @param mixed $eventData
     *
     * @throws \PHPHearthSim\Exception\Entity\InvalidEventException when event name is not recognized
     * @return \PHPHearthSim\Model\Entity
     */
    public function emit($eventName, $eventData = null) {
        // Only send signal if we have a board
        if ($this->board instanceof Board) {

            switch ($eventName) {

                // When an entity is created
                case EntityEvent::EVENT_ENTITY_CREATE:
                    $event = new EntityCreateEvent($this, $eventData);
                    break;

                // When an entity triggers deathrattle
                case EntityEvent::EVENT_ENTITY_DEATHRATTLE:
                    $event = new EntityDeathrattleEvent($this, $eventData);
                    break;

                // When an entity takes damage
                case EntityEvent::EVENT_ENTITY_TAKE_DAMAGE:
                    $event = new EntityTakeDamageEvent($this, $eventData);
                    break;

                // When an entity received healing
                case EntityEvent::EVENT_ENTITY_RECEIVE_HEAL:
                    $event = new EntityReceiveHealEvent($this, $eventData);
                    break;

                // When an entity gained armor
                case EntityEvent::EVENT_ENTITY_GAIN_ARMOR:
                    $event = new EntityGainArmorEvent($this, $eventData);
                    break;

                // When an entity removed armor
                case EntityEvent::EVENT_ENTITY_REMOVE_ARMOR:
                    $event = new EntityRemoveArmorEvent($this, $eventData);
                    break;

                // Invalid event
                default:
                    throw new InvalidEventException($eventName . ' is not a valid entity event signal');
                    break;
            }

            // Send the event signal to the board emitter
            $this->board->emit($eventName, $event);

        }

        return $this;
    }

    /**
     * Set the entity adjustments
     *
     * @param \PHPHearthSim\Model\EntityyAdjustment[] $adjustments
     * @return \PHPHearthSim\Model\Entity
     */
    public function setAdjustments(array $adjustments) {
        $this->adjustments = $adjustments;

        return $this;
    }

    /**
     * Get the entity adjustments
     *
     * @return \PHPHearthSim\Model\EntityyAdjustment[]
     */
    public function getAdjustments() {
        return $this->adjustments;
    }

    /**
     * Add adjustment to list
     *
     * @param \PHPHearthSim\Model\EntityAdjustment $adjustment
     * @return \PHPHearthSim\Model\Entity
     */
    public function addAdjustment(EntityAdjustment $adjustment) {
        $this->adjustments[] = $adjustment;

        return $this;
    }

    /**
     * Set the last signal received
     *
     * @param string $eventName
     * @param \PHPHearthSim\Event\EntityEvent $event
     * @return \PHPHearthSim\Model\Entity
     */
    public function setLastSignalReceived($eventName, EntityEvent $event) {
        $this->lastSignalReceived = ['signal' => $eventName, 'event' => $event];

        return $this;
    }

    /**
     * Get the last signal received
     *
     * @return mixed
     */
    public function getLastSignalReceived() {
        return $this->lastSignalReceived;
    }

    /**
     * Get the entity name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Get the entity base mana cost
     *
     * @return int
     */
    public function getBaseCost() {
        return $this->baseCost;
    }

    /**
     * Get the entity base health
     *
     * @return int
     */
    public function getBaseHealth() {
        return $this->baseHealth;
    }

    /**
     * Get the entity base attack
     *
     * @return int
     */
    public function getBaseAttack() {
        return $this->baseAttack;
    }

    /**
     * Get the entity type
     *
     * @return string
     */
    public function getRarity() {
        return $this->rarity;
    }

    /**
     * Get the current entity mana cost
     *
     * @return int
     */
    public function getCost() {
        return $this->cost;
    }

    /**
     * Get the current entity health
     *
     * @return int
     */
    public function getHealth() {
        $health = $baseHealth = $this->baseHealth;

        foreach ($this->getAdjustments() as $adjustment) {
            // check for health adjustments
            switch ($adjustment->getType()) {
                // Adjust the health, add or subtract value
                case EntityAdjustment::ADJUSTMENT_HEALTH:
                    $health += $adjustment->getValue();

                    // Make sure health is never higher than maximum health
                    if ($health > $baseHealth) {
                        $health = $baseHealth;
                    }

                    break;

                // Force new health value
                case EntityAdjustment::SET_HEALTH:
                    $health = $adjustment->getValue();
                    break;

                // TODO: Figure out what we do about "auras", like wolf that gives +1 attack to adjecent minions.
                // Option 1) Use a AURA_ATTACK / AURA_HEALTH type and process them at the end
                // Option 2) Use a different mechanic, not adjustments
            }
        }

        return $health;
    }

    /**
     * Get the current entity attack
     *
     * @return int
     */
    public function getAttack() {
        return $this->attack;
    }

    /**
     * Check to see if entity has a trait
     *
     * @param string $trait
     * @return boolean
     */
    public function hasTrait($trait) {
        // Loop and find trait by name
        foreach ($this->traits as $traitPath) {
            if (substr_count($traitPath, $trait) > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * temporary
     * TODO: implement or remove enterBattlefield
     */
    public function enterBattlefield() {

    }

    /**
     * temporary
     * TODO: implement or remove exitBattlefield
     */
    public function exitBattlefield() {

    }

    /**
     * temporary
     * TODO: implement or remove attack
     */
    public function attack() {

    }


    /**
     * temporary
     * TODO: implement or remove doDamage
     */
    public function doDamage() {

    }

    /**
     * Called for each minion that is on the battlefield
     * Useful for entities that alter game behavior, like Auchenai Soulpriest or Brann Bronzebeard
     *
     * @return \PHPHearthSim\Model\Entity;
     */
    public function onBattlefield() {
       return $this;
    }

    /**
     * Function to return if unit has been silenced or not
     *
     * @return boolean
     */
    public function isSilenced() {
        return $this->silenced;
    }

    /**
     * When the entity takes damage
     *
     * @param number $amount The amount of damage taken
     * @param \PHPHearthSim\Model\Entity $from The entity that did damage to us
     * @return \PHPHearthSim\Model\Entity
     */
    public function takeDamage($amount = 0, Entity $from = null) {
        // Just make sure damage is a positive value so we don't get any wierd interactions
        if ($amount < 0) {
            $amount = 0;
        }

        // Make sure damage is taken
        if ($amount > 0) {
            // Apply adjustment to health
            $this->addAdjustment(new EntityAdjustment(EntityAdjustment::ADJUSTMENT_HEALTH, -$amount));

            // Emit that we took damage
            $this->emit(EntityEvent::EVENT_ENTITY_TAKE_DAMAGE, ['amount' => $amount]);
        }

        return $this;
    }

    /**
     * Trigger healing on entity
     *
     * @param number $amount The amount of healing received
     * @param \PHPHearthSim\Model\Entity $from The entity that did the healing to us
     * @return \PHPHearthSim\Model\Entity
     */
    public function healFor($amount = 0, Entity $from = null) {
        // Just make sure damage is a positive value so we don't get any wierd interactions
        if ($amount < 0) {
            $amount = 0;
        }

        // Check and adjust values
        if ($from != null) {
            // Auchenai Soulpriest turns healing into damage
            if ($this->getBoard()->isOnBattlefield('PHPHearthSim\Game\Minion\A\AuchenaiSoulpriest', $from->getOwner())) {
                return $this->takeDamage($amount, $from);
            // Professor Velen doubles the healing received
            } else if ($this->getBoard()->isOnBattlefield('PHPHearthSim\Game\Minion\P\ProfessorVelen', $from->getOwner())) {
                $amount = $amount * 2;
            }
        }

        // Apply adjustment to health
        $this->addAdjustment(new EntityAdjustment(EntityAdjustment::ADJUSTMENT_HEALTH, $amount));

        // Emit that we received healing
        $this->emit(EntityEvent::EVENT_ENTITY_RECEIVE_HEAL, ['amount' => $amount]);

        return $this;
    }

    /**
     * When the entity is destroyed
     *
     * @return \PHPHearthSim\Model\Entity;
     */
    public function destroy() {
        if (!$this->isSilenced() && $this instanceof Deathrattle) {
            // TODO: see if it matters what order the emit and deathrattle() is called.
            $this->emit(EntityEvent::EVENT_ENTITY_DEATHRATTLE);
            $this->deathrattle();
        }

        return $this;
    }

    /**
     * Silence the entity, removing current buffs and deathrattle effects
     * TODO: Need a better way to handle deathrattle, for example Soul of the Forest can be applied to existing minions.
     *
     * @return \PHPHearthSim\Model\Entity
     */
    public function silence() {
        $this->silenced = true;

        // TODO: Loop and remove buffs or debuffs.

        return $this;
    }

}