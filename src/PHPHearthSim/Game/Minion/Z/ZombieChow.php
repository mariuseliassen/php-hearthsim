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
use PHPHearthSim\Model\Mechanic\Deathrattle;

/**
 * Zombie Chow
 * Common minion
 *
 * @class ZombieChow
 */
class ZombieChow extends Entity implements Neutral, Minion, Deathrattle {

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
     * ZombieChow deathrattle:
     * Restore 5 Health to the enemy hero.
     */
    public function deathrattle() {
        // We pass it to adjustHealValue to support interactions like Professor Velen
        $this->getEnemyHero()->healFor(5, $this);
    }

}