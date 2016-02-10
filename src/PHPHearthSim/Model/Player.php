<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
namespace PHPHearthSim\Model;

use PHPHearthSim\Model\Deck;
use PHPHearthSim\Model\Hero;
use PHPHearthSim\Exception\Player\NotEnoughManaException;

/**
 * This class is responsible to hold player name, deck, hero information (health, weapon, etc).
 *
 * @class Player
 * @property int $id set/get the player id
 * @property string $name set/get the player name
 * @property \PHPHearthSim\Model\Board $board set/get the board reference
 * @property \PHPHearthSim\Model\Deck $deck set/get the player deck
 * @property \PHPHearthSim\Model\Hero $hero set/get the player hero
 */
class Player {

    /**
     * The player id
     *
     * @var int
     */
    protected $id;

    /**
     * The player name
     *
     * @var string
     */
    protected $name;

    /**
     * Board reference
     *
     * @var \PHPHearthSim\Model\Board
     */
    protected $board;

    /**
     * The player deck
     *
     * @var \PHPHearthSim\Model\Deck
     */
    protected $deck;

    /**
     * The available mana
     *
     * @var int
     */
    protected $availableMana = 1;

    /**
     * Mana available start of turn
     *
     * @var int
     */
    protected $turnStartMana = 1;

    /**
     * Locked (overloaded) mana
     *
     * @var int
     */
    protected $lockedMana = 0;

    /**
     * Array that holds queued lock data. Key is turn mana is locked
     *
     * @example [2 => 3] means that 3 mana was locked on turn 2
     *
     * @var array
     */
    protected $lockedManaQueue = [];

    /**
     * Previous turn number. Used for locking mana crystals
     *
     * @var int
     */
    protected $myPreviousTurnNumber = 0;

    /**
     * The player hero
     *
     * @var \PHPHearthSim\Model\Hero
     */
    protected $hero;

    /**
     * Construct a new player
     */
    public function __construct() {

    }

    /**
     * Set the player id
     *
     * @param int $id
     * @return \PHPHearthSim\Model\Player
     */
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the player id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set player name
     *
     * @param string $name
     * @return \PHPHearthSim\Model\Player
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get player name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set the board reference
     *
     * @param \PHPHearthSim\Model\Board $board
     * @return \PHPHearthSim\Model\Player
     */
    public function setBoard(Board $board) {
        $this->board = $board;

        return $this;
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
     * Set the player deck
     *
     * @param \PHPHearthSim\Model\Deck $deck
     * @return \PHPHearthSim\Model\Player
     */
    public function setDeck(Deck $deck) {
        $this->deck = $deck;

        return $this;
    }

    /**
     * Get the player deck
     *
     * @return \PHPHearthSim\Model\Deck
     */
    public function getDeck() {
        return $this->deck;
    }


    /**
     * Set the player hero
     *
     * @param \PHPHearthSim\Model\Hero $hero
     * @return \PHPHearthSim\Model\Player
     */
    public function setHero(Hero $hero) {
        // Set owner
        $hero->setOwner($this);
        // Assign hero
        $this->hero = $hero;

        return $this;
    }

    /**
     * Get the player hero
     *
     * @return \PHPHearthSim\Model\Hero
     */
    public function getHero() {
        return $this->hero;
    }

    /**
     * Helper function to initialize new turn
     *
     * @param int $turn The number number that started
     *
     * @return \PHPHearthSim\Model\Player
     */
    public function startTurn($turn = 1) {
        // Gain 1 mana crystal each turn
        $this->gainManaCrystals(1);

        // Reset available mana == turn start mana
        $this->setAvailableMana($this->getTurnStartMana());


        // Set locked mana from previous turn if any
        $lockedMana = isset($this->lockedManaQueue[$this->myPreviousTurnNumber]) ?
            (int)$this->lockedManaQueue[$this->myPreviousTurnNumber] : 0;

        $this->setLockedMana($lockedMana);

        return $this;
    }

    /**
     * Helper function to end turn
     *
     * @param int $turn The number number that ended
     *
     * @return \PHPHearthSim\Model\Player
     */
    public function endTurn($turn = 1) {
        // Store previous turn number
        $this->myPreviousTurnNumber = $turn;

        return $this;
    }

    /**
     * Method to adjust healing values
     *
     * @param number $value
     * @return number
     */
    public function adjustHealValue($value) {
        return $value;
    }

    /**
     * Helper function to see if we can play a spell or minion of cost $manaCost
     *
     * @param int $manaCost The mana cost to play
     *
     * @return boolean True if can afford, false if not
     */
    public function canAffordToPlay($manaCost) {
        return $this->getAvailableMana() >= $manaCost;
    }

    /**
     * Get available mana
     *
     * @return int
     */
    public function getAvailableMana() {
        // Available mana is reduced by locked mana
        return $this->availableMana - $this->getLockedMana();
    }

    /**
     * Set available mana
     *
     * @param int $mana The available mana
     *
     * @return \PHPHearthSim\Model\Player
     */
    public function setAvailableMana($mana = 0) {
        $this->availableMana = $mana;

        // Make sure mana crystals never exceed maximum set by board
        if ($this->availableMana > Board::MAX_MANA_CRYSTALS) {
            $this->availableMana = Board::MAX_MANA_CRYSTALS;
        }

        return $this;
    }

    /**
     * Get locked mana
     *
     * @return int
     */
    public function getLockedMana() {
        return $this->lockedMana;
    }

    /**
     * Set locked mana
     *
     * @param int $locked The amount to lock
     *
     * @return \PHPHearthSim\Model\Player
     */
    public function setLockedMana($amount = 0) {
        $this->lockedMana = $amount;

        return $this;
    }


    /**
     * Queue locked mana for next turn
     *
     * @param int $amount The amount of mana to queue for locking
     *
     * @return \PHPHearthSim\Model\Player
     */
    public function queueLockedMana($amount = 0) {
        // Add amount to turn
        if (isset($this->lockedManaQueue[$this->getBoard()->getTurn()])) {
            $this->lockedManaQueue[$this->getBoard()->getTurn()] += $amount;
        } else {
            $this->lockedManaQueue[$this->getBoard()->getTurn()] = $amount;
        }

        return $this;
    }

    /**
     * Method to gain mana crystals
     *
     * @param int $amount The amount of mana to add
     * @param boolean $addToAvailable If true also make mana available this turn, defaults to false
     * @param boolean $temporaryManaCrystal If true don't add to turn start mana, defaults to false
     *
     * @return \PHPHearthSim\Model\Player
     */
    public function gainManaCrystals($amount = 0, $addToAvailable = false, $temporaryManaCrystal = false) {
        // Add mana if not temporary
        if (!$temporaryManaCrystal) {
            $this->turnStartMana += $amount;
        }

        // Check if add to available mana
        if ($addToAvailable) {
            $this->availableMana += $amount;
        }

        // Make sure mana crystals never exceed maximum set by board
        if ($this->turnStartMana > Board::MAX_MANA_CRYSTALS) {
            $this->turnStartMana = Board::MAX_MANA_CRYSTALS;
        }
        if ($this->availableMana > Board::MAX_MANA_CRYSTALS) {
            $this->availableMana = Board::MAX_MANA_CRYSTALS;
        }


        return $this;
    }

    /**
     * Method to destroy mana crystals
     *
     * @param int $amount The amount of mana crystals to destroy
     *
     * @return \PHPHearthSim\Model\Player
     */
    public function destroyManaCrystal($amount = 0) {
        if ($amount > 0) {
            // Reduce both available mana and turn start mana
            $this->turnStartMana -= $amount;
            $this->availableMana -= $amount;

            // Make sure mana crystals never go below 0
            if ($this->turnStartMana < 0) {
                $this->turnStartMana = 0;
            }
            if ($this->availableMana < 0) {
                $this->availableMana = 0;
            }
        }

        return $this;
    }

    /**
     * Get turn start mana
     *
     * @return int
     */
    public function getTurnStartMana() {
        return $this->turnStartMana;
    }

    /**
     * Set turn start mana
     *
     * @param int $mana The turn start mana
     *
     * @return \PHPHearthSim\Model\Player
     */
    public function setTurnStartMana($mana = 0) {
        $this->turnStartMana = $mana;

        // Make sure mana crystals never exceed maximum set by board
        if ($this->turnStartMana > Board::MAX_MANA_CRYSTALS) {
            $this->turnStartMana = Board::MAX_MANA_CRYSTALS;
        }

        return $this;
    }

    /**
     * Method to correcly make sure we have enough mana and exhaust it.
     *
     * @param int $amount The amount of mana to use
     *
     * @throws NotEnoughManaException When player does not have enough mana to use
     * @return \PHPHearthSim\Model\Player
     */
    public function useMana($amount = 0) {
        // Make sure we have enough mana to spend
        if (!$this->canAffordToPlay($amount)) {
            throw new NotEnoughManaException("Attempted to use ".$amount." mana with only " . $this->availableMana . " mana left.");
        }

        // Deduct mana
        $this->availableMana -= $amount;

        return $this;
    }

    /**
     * Gateway function to add entity to battlefield
     *
     * @see \PHPHearthSim\Model\Board->addToBattlefield
     *
     * @param \PHPHearthSim\Model\Entity $entity
     * @param int|null $newPosition The new entity position, if null we place it at the end
     *
     * @return boolean "true" if entity was placed on battlefield, "false" if entity was not placed on battlefield
     */
    public function addToBattlefield(Entity $entity, $newPosition = null) {
        return $this->getBoard()->addToBattlefield($entity, $this, $newPosition);
    }

    /**
     * Helper function to get battlefield for this player
     *
     * @return array
     */
    public function getBattlefield() {
        return $this->getBoard()->getBattlefieldForPlayer($this);
    }
}