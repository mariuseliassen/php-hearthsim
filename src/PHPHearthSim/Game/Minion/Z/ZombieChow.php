<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
namespace PHPHearthSim\Game\Minion\Z;

use PHPHearthSim\Model\EntityClass\Neutral;
use PHPHearthSim\Model\Minion;
use PHPHearthSim\Model\Entity;
use PHPHearthSim\Game\Mechanic\Deathrattle\Z\ZombieChowDeathrattle;

/**
 * Zombie Chow
 * Common minion
 *
 * @class ZombieChow
 */
class ZombieChow extends Minion implements Neutral {

    /** {@inheritDoc} */
    protected $rarity = Entity::RARITY_COMMON;

    /** {@inheritDoc} */
    protected $baseCost = 1;

    /** {@inheritDoc} */
    protected $name = 'Zombie Chow';

    /** {@inheritDoc} */
    protected $baseAttack = 2;

    /** {@inheritDoc} */
    protected $baseHealth = 3;

    /**
     * {@inheritDoc}
     *
     * @param array $options Options to set during initialization
     * */
    public function __construct($options = []) {
        $options['deathrattle'] = [new ZombieChowDeathrattle()];

        parent::__construct($options);
    }

}