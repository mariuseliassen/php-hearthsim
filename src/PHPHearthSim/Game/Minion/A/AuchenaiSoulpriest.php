<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
namespace PHPHearthSim\Game\Minion\A;

use PHPHearthSim\Model\EntityClass\Priest;
use PHPHearthSim\Model\Minion;
use PHPHearthSim\Model\Entity;

/**
 * Auchenai Soulpriest
 * Rare priest minion
 *
 * @class AuchenaiSoulpriest
 */
class AuchenaiSoulpriest extends Minion implements Priest {

    /** {@inheritDoc} */
    protected $rarity = Entity::RARITY_RARE;

    /** {@inheritDoc} */
    protected $baseCost = 4;

    /** {@inheritDoc} */
    protected $name = 'Auchenai Soulpriest';

    /** {@inheritDoc} */
    protected $baseAttack = 3;

    /** {@inheritDoc} */
    protected $baseHealth = 5;

}