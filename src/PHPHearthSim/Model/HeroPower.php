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
     * Constructor
     * HeroPower is abstract, but the extended classes hold information about triggers and functionality
     *
     * @param array $options Options to set during initialization
     */
    public function __construct(array $options = []) {
        // Call the parent constructor to set up events, etc.
        parent::__construct($options);
    }

    /**
     * Use hero power on target.
     * Checks if entity is targetable by hero power should already be performed in Hero->useHeroPower.
     * Never call this method directly.
     *
     * @param \PHPHearthSim\Model\Entity $target
     * @return \PHPHearthSim\Model\HeroPower
     */
    public function useOn(Entity $target) {
        return $this;
    }
}