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
     * @return \PHPHearthSim\Model\Player
     */
    public function startTurn() {
        return $this;
    }

    /**
     * Helper function to end turn
     *
     * @return \PHPHearthSim\Model\Player
     */
    public function endTurn() {
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