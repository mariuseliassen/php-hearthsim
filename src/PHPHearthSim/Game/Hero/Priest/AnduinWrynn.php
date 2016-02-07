<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 23 12 2015
 */
namespace PHPHearthSim\Game\Hero\Priest;

use PHPHearthSim\Model\EntityClass\Priest;
use PHPHearthSim\Model\Hero;
use PHPHearthSim\Game\HeroPower\Priest\LesserHeal;

/**
 * Anduin Wrynn.
 * Priest hero
 *
 * - Has "Lesser Heal" hero power. Restore 2 health
 * - Alliance
 *
 * @class AnduinWrynn
 */
class AnduinWrynn extends Hero implements Priest {

    /** {@inheritDoc} */
    protected $name = 'Anduin Wrynn';

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
        // Priest have the "Lesser heal" hero power. Restore 2 health
        $options['heroPower'] = new LesserHeal();

        // Call the constructor to apply hero power
        parent::__construct($options);
    }
}