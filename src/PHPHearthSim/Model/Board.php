<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
namespace PHPHearthSim\Model;

use PHPHearthSim\Model\Minion;
use PHPHearthSim\Model\Player;

use PHPHearthSim\Event\EntityEvent;
use PHPHearthSim\Event\Board\BoardTurnEndEvent;
use PHPHearthSim\Event\Board\BoardTurnStartEvent;

use Symfony\Component\EventDispatcher\EventDispatcher;

use PHPHearthSim\Exception\Board\InvalidBattlefieldOwnerException;
use PHPHearthSim\Exception\Board\InvalidBattlefieldEntityException;
use PHPHearthSim\Exception\Board\MinionNotFoundAtPositionException;

/**
 * Class to hold and control the game board
 *
 * Responsible for:
 * - Board minions and adjustments
 * - Heroes
 * - Unit attacks
 * - Playing card (entities) from "hand"
 * - Draw cards (from deck)
 *
 *
 * @class Board
 * @property-read int $entityCounter get the entity count
 * @property int $turn set/get the current turn number
 * @property \PHPHearthSim\Model\Player $me set/get my player
 * @property \PHPHearthSim\Model\Player $opponent set/get opponent player
 * @property \PHPHearthSim\Model\Player $activePlayer set/get active player
 * @property \Symfony\Component\EventDispatcher\EventDispatcher $dispatcher set/get the event dispatcher
 */
class Board {

    /**
     * Maximum size of the battlefield
     *
     * @var int
     */
    const MAX_BATTLEFIELD_SIZE = 7;

    /**
     * The entity counter
     *
     * @var int
     */
    private $entityCounter = 0;

    /**
     * Current turn number
     *
     * @var int
     */
    protected $turn;

    /**
     * My player
     *
     * @var \PHPHearthSim\Model\Player
     */
    protected $me;

    /**
     * Opponent player
     *
     * @var \PHPHearthSim\Model\Player
     * */
    protected $opponent;

    /**
     * Active player
     *
     * @var \PHPHearthSim\Model\Player
     * */
    protected $activePlayer;

    /**
     * Event dispatcher
     *
     * @var \Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected $dispatcher;

    /**
     * The battlefield. List of all active units and their placement
     * Two dimentional array where first index is the player and the second index is the position
     * Example: [0 =>
     *              [0 => <Entity>, 1 => <Entity>],
     *              1 => [0 => <Entity>]
     *          ]
     *
     * @var array
     */
    protected $battlefield = [];

    /**
     * The graveyard. List of all minions that have been destroyed this game.
     *
     * @var array
     */
    protected $graveyard = [];

    /**
     * Construct new board
     *
     * @param \PHPHearthSim\Model\Player $me
     * @param \PHPHearthSim\Model\Player $opponent
     */
    public function __construct(Player $me, Player $opponent) {
        // Reset entity counter
        $this->entityCounter = 0;
        // Create event dispatcher
        $this->dispatcher = new EventDispatcher();

        // Set the players
        $this->setMe($me);
        $this->setOpponent($opponent);

        // Initialize the turn
        $this->setTurn(1);

        // Toss a coin
        $coin = rand(0, 1);

        // Set active player based on coin result
        $activePlayer = ($coin == 0) ? $me : $opponent;
        $this->setActivePlayer($activePlayer);
    }

    /**
     * Update players hero and hero power states.
     * This method should be called if players get new heroes during the game
     *
     * @return \PHPHearthSim\Model\Board
     */
    public function updatePlayers() {
        $this->setMe($this->getMe());
        $this->setOpponent($this->getOpponent());

        return $this;
    }

    /**
     * Set the event dispatcher
     *
     * @param \Symfony\Component\EventDispatcher\EventDispatcher $dispatcher
     *
     * @return \PHPHearthSim\Model\Board
     */
    public function setDispatcher(EventDispatcher $dispatcher) {
        $this->dispatcher = $dispatcher;

        return $this;
    }

    /**
     * Get the event dispatcher
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    public function getDispatcher() {
        return $this->dispatcher;
    }

    /**
     * Subscribe to events
     *
     * @param unknown $subscriber
     * @return \PHPHearthSim\Model\Board
     */
    public function subscribe($subscriber) {
        $this->getDispatcher()->addSubscriber($subscriber);

        return $this;
    }

    /**
     * Emit an event to the rest of the game
     *
     * @param string $eventName
     * @param \PHPHearthSim\Event\EntityEvent $event
     * @return \PHPHearthSim\Game\Board
     */
    public function emit($eventName, EntityEvent $event) {
        $this->getDispatcher()->dispatch($eventName, $event);

        return $this;
    }

    /**
     * Set the turn number
     *
     * @param int $turn
     * @return \PHPHearthSim\Game\Board
     */
    public function setTurn($turn) {
        $this->turn = $turn;

        return $this;
    }

    /**
     * Get the turn number
     *
     * @return int
     */
    public function getTurn() {
        return $this->turn;
    }

    /**
     * Set my player
     *
     * @param \PHPHearthSim\Model\Player $me
     * @return \PHPHearthSim\Game\Board
     */
    public function setMe(Player $me) {
        // Set board reference
        $me->setBoard($this);

        // Set board and owner on hero
        if ($me->getHero() instanceof Hero) {
            $me->getHero()->setBoard($this);
            $me->getHero()->setOwner($me);

            // Set board and owner on heropower
            if ($me->getHero()->getHeroPower() instanceof HeroPower) {
                $me->getHero()->getHeroPower()->setBoard($this);
                $me->getHero()->getHeroPower()->setOwner($me);
            }
        }

        $this->me = $me;

        return $this;
    }

    /**
     * Return my player
     *
     * @return \PHPHearthSim\Model\Player
     */
    public function getMe() {
        return $this->me;
    }

    /**
     * Set opponent player
     *
     * @param \PHPHearthSim\Model\Player $opponent
     * @return \PHPHearthSim\Game\Board
     */
    public function setOpponent(Player $opponent) {
       // Set board reference
       $opponent->setBoard($this);

       // Set board on hero
       if ($opponent->getHero() instanceof Hero) {
           $opponent->getHero()->setBoard($this);
           $opponent->getHero()->setOwner($opponent);

           // Set board and owner on heropower
           if ($opponent->getHero()->getHeroPower() instanceof HeroPower) {
               $opponent->getHero()->getHeroPower()->setBoard($this);
               $opponent->getHero()->getHeroPower()->setOwner($opponent);
           }
       }

       $this->opponent = $opponent;

       return $this;
    }

    /**
     * Return opponent player
     *
     * @return \PHPHearthSim\Model\Player
     */
    public function getOpponent() {
        return $this->opponent;
    }

    /**
     * Set the active player
     *
     * @param \PHPHearthSim\Model\Player $activePlayer
     * @return \PHPHearthSim\Model\Board
     */
    public function setActivePlayer(Player $activePlayer) {
        $this->activePlayer = $activePlayer;

        return $this;
    }

    /**
     * Get the active player
     *
     * @return \PHPHearthSim\Model\Player
     */
    public function getActivePlayer() {
        return $this->activePlayer;
    }

    /**
     * Return a unique entity identifier based on entityCounter
     *
     * @return string
     */
    public function generateEntityId() {
        $this->entityCounter++;
        return 'ENT_' . str_pad($this->entityCounter, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Method to handle end turn logic
     *
     * @return \PHPHearthSim\Model\Board
     */
    public function endTurn() {
        // Emit end turn signal
        $this->emit(EntityEvent::EVENT_BOARD_TURN_END,
                    new BoardTurnEndEvent(['turn' => $this->turn,
                                           'activePlayer' => $this->getActivePlayer()]));

        // Increment turn counter
        $this->turn++;
        // Call end turn for current active player
        $this->getActivePlayer()->endTurn();
        // Toggle active player and trigger start turn for new active player
        $this->toggleActivePlayer()->getActivePlayer()->startTurn();

        // Emit start turn signal
        $this->emit(EntityEvent::EVENT_BOARD_TURN_START,
                new BoardTurnStartEvent(['turn' => $this->turn,
                                       'activePlayer' => $this->getActivePlayer()]));

        return $this;
    }

    /**
     * Helper function to toggle active player based on current active player
     *
     * @return \PHPHearthSim\Model\Board
     */
    private function toggleActivePlayer() {
        $newActivePlayer = ($this->getActivePlayer()->getId() == $this->getMe()->getId()) ? $this->getOpponent() : $this->getMe();
        $this->setActivePlayer($newActivePlayer);

        return $this;
    }


    /**
     * Method to add a minion to the battlefield
     *
     * @param \PHPHearthSim\Model\Entity $entity
     * @param \PHPHearthSim\Model\Player $player
     * @param int|null $newPosition The new entity position, if null we place it at the end
     *
     * @throws \PHPHearthSim\Exception\Board\InvalidBattlefieldOwnerException when player is not instance of Player
     * @throws \PHPHearthSim\Exception\Board\InvalidBattlefieldEntityException when entity is not instance of Minion
     * @return boolean "true" if entity was placed on battlefield, "false" if entity was not placed on battlefield
     */
    public function addToBattlefield(Entity $entity, Player $player, $newPosition = null) {
        // Make sure $player is a Player
        if (!$player instanceof Player) {
            throw new InvalidBattlefieldOwnerException('Owner of entity passed is not an instance of type Player');
        }
        // Make sure entity is a minion, can't play spell on the battlefield!
        if (!$entity instanceof Minion) {
            throw new InvalidBattlefieldEntityException('Only entities of type Minion can be placed on the battlefield');
        }

        // Update entity references
        $entity->setBoard($this);
        $entity->setOwner($player);

        // Get minions
        $minions = $this->getBattlefieldForPlayer($player);

        // Make sure we have room for another minion
        if (count($minions) < Board::MAX_BATTLEFIELD_SIZE) {

            // If not position is provided, we generate a new index
            if ($newPosition == null) {
                $newPosition = count($minions);
            }

            // Insert minion at position
            array_splice($minions, $newPosition + 1, 0, [$entity]);

            // Update battlefield for player
            $this->battlefield[$player->getid()] = $minions;

            return true;
        }

        return false;
    }

    /**
     * Get minion from battlefield at position for player
     *
     * @param \PHPHearthSim\Model\Player $player
     * @param int $position
     *
     * @throws MinionNotFoundAtPositionException
     * @return \PHPHearthSim\Model\Entity;
     */
    public function getMinionOnBattlefieldAtPosition(Player $player, $position) {
        $minions = $this->getBattlefieldForPlayer($player);

        if (!isset($minions[$position])) {
            throw new MinionNotFoundAtPositionException('No minion was found at position ' . $position . ' for player ' . $player->getName());
        }

        return $minions[$position];
    }

    /**
     * Return battlefield for player
     *
     * @param \PHPHearthSim\Model\Player $player
     * @return array
     */
    public function getBattlefieldForPlayer(Player $player) {
        // Create empty battlefield if it does not exist
        if (!isset($this->battlefield[$player->getId()])) {
            $this->battlefield[$player->getId()] = [];
        }

        return $this->battlefield[$player->getId()];
    }

    /**
     * Check if a unit is on the battlefield for a specific player
     * Optional flag to check if unit is also not silenced
     *
     * @param string $entityName
     * @param \PHPHearthSim\Model\Player $player
     * @param bool $checkIfSilenced If true flag then we also check that the unit is not silenced
     *
     * @return boolean
     */
    public function isOnBattlefield($entityName, Player $player, $checkIfSilenced = true) {
        // Get minions on battlefield
        $minions = $this->getBattlefieldForPlayer($player);

        // No minions on board
        if (empty($minions)) {
            return false;
        }

        // Loop through minions
        foreach ($minions as $position => $minion) {
            // We found a minion that we were looking for
            if (is_a($minion, $entityName)) {
                // Only return true if we are not checking silence flag, or if unit is not silenced
                if (!$checkIfSilenced || ($checkIfSilenced && !$minion->isSilenced())) {
                    return true;
                }
            }
        }

        // No minions found
        return false;
    }
}