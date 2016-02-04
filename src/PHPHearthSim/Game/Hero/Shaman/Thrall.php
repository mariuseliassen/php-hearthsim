<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015-2016 Switchback
 * @date: 04 02 2016
 */
namespace PHPHearthSim\Game\Hero\Shaman;

use PHPHearthSim\Model\Hero;
use PHPHearthSim\Game\HeroPower\Shaman\TotemicCall;

/**
 * Thrall.
 * Shaman hero
 *
 * - Has "Totemic Call" hero power. Summon a random totem
 * - Horde
 *
 * @class Thrall
 */
class Thrall extends Hero {

    /** {@inheritDoc} */
    protected $name = 'Thrall';

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
        // Shaman have the "Totemic Call" hero power. Summon a random totem
        $options['heroPower'] = new TotemicCall();

        // Call the constructor to apply hero power
        parent::__construct($options);
    }
}