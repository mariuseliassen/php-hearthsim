<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
namespace PHPHearthSim\Model;

use PHPHearthSim\Model\Player;

/**
 * This class is responsible to hold and control deck interaction
 *
 * @class Deck
 * @property \PHPHearthSim\Model\Player $player set/get the player that owns the deck
 * @property \PHPHearthSim\Model\Entity[] $cards set/get list of cards in the deck
 */
class Deck {

    /**
     * Player that owns the deck
     *
     * @var \PHPHearthSim\Model\Player
     */
    protected $player;

    /**
     * List of cards in the deck
     *
     * @var \PHPHearthSim\Model\Entity[]
     */
    protected $cards;

    /**
     * Construct a new deck
     */
    public function __construct() {

    }

    /**
     * Set the player that owns the deck
     *
     * @param \PHPHearthSim\Model\Player $player
     * @return \PHPHearthSim\Model\Deck
     */
    public function setPlayer(Player $player) {
       $this->player = $player;

        return $this;
    }

    /**
     * Return the player that owns the deck
     *
     * @return \PHPHearthSim\Model\Player
     */
    public function getPlayer() {
        return $this->player;
    }

    /**
     * Set the cards in deck
     *
     * @param array<\PHPHearthSim\Model\Entity> $cards
     * @return \PHPHearthSim\Model\Deck
     */
    public function setCards(array $cards) {
        $this->cards = $cards;

        return $this;
    }

    /**
     * Get the cards in the deck
     *
     * @return array<\PHPHearthSim\Model\Entity>
     */
    public function getCards() {
        return $this->cards;
    }

    /**
     * Get remaining deck count
     *
     * @return int
     */
    public function getCount() {
        return count($this->cards);
    }

    /**
     * Method to see if you can draw from your deck
     *
     * @return boolean
     */
    public function canDraw() {
        return ($this->getCount() > 0);
    }
}