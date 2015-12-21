<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
namespace PHPHearthSim\Game\Card\Z;

use PHPHearthSim\Model\Entity;
use PHPHearthSim\Model\Mechanic\DeathrattleInterface;

/**
 * Zombie Chow
 * Basic unit card
 *
 * @class ZombieChow
 */
class ZombieChow extends Entity implements DeathrattleInterface {

    /** {@inheritDoc} */
    protected $rarity = Entity::RARITY_BASIC;

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
        // We pass it to adjustHealValue to support interactions like Auchenai Soulpriest
        $this->getEnemyHero()->healFor($this->getOwner()->adjustHealValue(5));
    }

}