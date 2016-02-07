<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 18 12 2015
 */
namespace PHPHearthSim\Game\Hero\Warrior;

use PHPHearthSim\Model\EntityClass\Warrior;
use PHPHearthSim\Model\Hero;
use PHPHearthSim\Game\HeroPower\Warrior\ArmorUp;

/**
 * Garrosh Hellscream.
 * Warrior hero
 *
 * - Has "Armor Up!" hero power. Gain 2 armor
 * - Horde
 *
 * @class GarroshHellscream
 */
class GarroshHellscream extends Hero implements Warrior {

    /** {@inheritDoc} */
    protected $name = 'Garrosh Hellscream';

    /** {@inheritDoc} */
    protected $baseCost = 0;

    /** {@inheritDoc} */
    protected $baseAttack = 0;

    /** {@inheritDoc} */
    protected $baseHealth = 30;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options = []) {
        // Warrior have the "Armor Up!" hero power. Gain 2 armor
        $options['heroPower'] = new ArmorUp();

        // Call the constructor to apply hero power
        parent::__construct($options);
    }
}