<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 18 12 2015
 */
namespace PHPHearthSim\Model;

use PHPHearthSim\Model\Entity;
use PHPHearthSim\Event\EntityEvent;
use PHPHearthSim\Event\Board\BoardTurnStartEvent;
use PHPHearthSim\Exception\HeroPower\HeroPowerAlreadyUsedThisTurnException;

/**
 * Hero power.
 * This class controls the players hero power functionality
 *
 * @class HeroPower
 */
abstract class HeroPower extends Entity {

    /** {@inheritDoc} */
    protected $rarity = Entity::RARITY_UNIQUE;

    /**
     * Number of times the hero power has been used this game
     *
     * @var int
     */
    protected $numUsedThisGame = 0;

    /**
     * Number of times the hero power has been used this turn
     *
     * @var int
     */
    protected $numUsedThisTurn = 0;

    /**
     * Constructor
     * HeroPower is abstract, but the extended classes hold information about triggers and functionality
     *
     * @param array $options Options to set during initialization
     */
    public function __construct(array $options = []) {
        // Listen to board start
        $options['listeners'] = [EntityEvent::EVENT_BOARD_TURN_START];

        // Call the parent constructor to set up events, etc.
        parent::__construct($options);
    }

    /** {@inheritDoc} */
    public function onBoardTurnStart(BoardTurnStartEvent $event) {
        // Reset the number of times hero power has been used this turn
        $this->numUsedThisTurn = 0;

        return $this;
    }


    /**
     *
     * @return boolean Returns true if the hero power can be used, false if not
     */
    public function canUse() {
        // TODO: Need to check the board for minions that control the way hero power can be used
        return ($this->numUsedThisTurn == 0);
    }

    /**
     * Use hero power on target.
     * Checks if entity is targetable by hero power should already be performed in Hero->useHeroPower.
     * Never call this method directly.
     *
     * @param \PHPHearthSim\Model\Entity $target
     * @return \PHPHearthSim\Model\HeroPower
     */
    public function useOn(Entity $target = null) {
        // Check that we can use the hero power
        if (!$this->canUse()) {
            throw new HeroPowerAlreadyUsedThisTurnException("The hero power has already been used maximum number of times this turn");
        }

        // Increment the number of times the hero power has been used
        $this->numUsedThisTurn++;

        return $this;
    }
}