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
use PHPHearthSim\Entity\Traits\Rarity\BasicRarityTrait;

/**
 * Zombie Chow
 * Basic unit card
 *
 * @class ZombieChow
 */
class ZombieChow extends Entity {
    use BasicRarityTrait;

    /** {@inheritDoc} */
    protected $baseCost = 1;

    /** {@inheritDoc} */
    protected $name = 'Zombie Chow';

    /** {@inheritDoc} */
    protected $baseAttack = 2;

    /** {@inheritDoc} */
    protected $baseHealth = 3;

}