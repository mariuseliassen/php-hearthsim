<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015-2016 Switchback
 * @date: 04 02 2016
 */
namespace PHPHearthSim\Game\Token\W;

use PHPHearthSim\Model\EntityClass\Shaman;
use PHPHearthSim\Model\Minion;
use PHPHearthSim\Model\Token;
use PHPHearthSim\Model\Entity;

/**
 * Wrath of Air Totem
 * Summoned random totem from shaman hero power
 *
 * @class WrathOfAirTotem
 */
class WrathOfAirTotem extends Entity implements Shaman, Minion, Token {

    /** {@inheritDoc} */
    protected $rarity = Entity::RARITY_COMMON;

    /** {@inheritDoc} */
    protected $baseCost = 1;

    /** {@inheritDoc} */
    protected $name = 'Wrath of Air Totem';

    /** {@inheritDoc} */
    protected $baseAttack = 0;

    /** {@inheritDoc} */
    protected $baseHealth = 2;

}