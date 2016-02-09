<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015-2016 Switchback
 * @date: 04 02 2016
 */
namespace PHPHearthSim\Game\Token\S;

use PHPHearthSim\Model\EntityClass\Shaman;
use PHPHearthSim\Model\Minion;
use PHPHearthSim\Model\Token;
use PHPHearthSim\Model\Entity;

/**
 * Searing Totem
 * Summoned random totem from shaman hero power
 *
 * @class SearingTotem
 */
class SearingTotem extends Minion implements Shaman, Token {

    /** {@inheritDoc} */
    protected $rarity = Entity::RARITY_COMMON;

    /** {@inheritDoc} */
    protected $baseCost = 1;

    /** {@inheritDoc} */
    protected $name = 'Searing Totem';

    /** {@inheritDoc} */
    protected $baseAttack = 1;

    /** {@inheritDoc} */
    protected $baseHealth = 1;

}