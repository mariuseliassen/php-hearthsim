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
use PHPHearthSim\Model\Player;
use PHPHearthSim\Model\HeroPower;

/**
 * Hero.
 * This class controls the players hero stats, weapons, interactions, hero power etc...
 *
 * @class Hero
 */
abstract class Hero extends Entity {

    /** {@inheritDoc} */
    protected $rarity = Entity::RARITY_UNIQUE;

    /**
     * The hero power
     * TODO: implement
     *
     * @var \PHPHearthSim\Model\HeroPower;
     */
    protected $heroPower;

    /**
     * Constructor
     * Hero is abstract, but the extended classes should in constructors pass in options for hero power etc
     *
     * @param array $options Options to set during initialization
     */
    public function __construct(array $options = []) {
        // Set hero power reference
        if (isset($options['heroPower']) && $options['heroPower'] instanceof HeroPower) {
            $this->heroPower = $options['heroPower'];
        }

        // Call the parent constructor to set up events, etc.
        parent::__construct($options);
    }

    /**
     * Return hero power
     *
     * @return \PHPHearthSim\Model\HeroPower
     */
    public function getHeroPower() {
        return $this->heroPower;
    }

    /**
     * Use hero power on target
     *
     * @param \PHPHearthSim\Model\Entity $target
     * @return \PHPHearthSim\Model\Hero
     */
    public function useHeroPower(Entity $target) {
        // TODO: make sure entity can be targeted (like Faerie Dragon can not be targeted by hero power)
        if ($this->heroPower != null) {
            $this->heroPower->useOn($target);
        }

        return $this;
    }
}