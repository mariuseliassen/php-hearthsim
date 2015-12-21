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
     * Reference to player that controls the hero
     *
     * @var \PHPHearthSim\Model\Player;
     */
    protected $player;

    /**
     * Constructor
     * Hero is abstract, but the extended classes should in constructors pass in options for hero power etc
     *
     * @param array $options Options to set during initialization
     */
    public function __construct(array $options = []) {
        // Set player reference
        if (isset($options['player']) && $options['player'] instanceof Player) {
            $this->player = $options['player'];
        }
        // Set hero power reference
        if (isset($options['heroPower']) && $options['heroPower'] instanceof HeroPower) {
            $this->heroPower = $options['heroPower'];
        }

        // Call the parent constructor to set up events, etc.
        parent::__construct($options);
    }
}