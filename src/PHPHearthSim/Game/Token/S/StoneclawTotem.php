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
 * Stoneclaw Totem
 * Summoned random totem from shaman hero power
 *
 * @class StoneclawTotem
 */
class StoneclawTotem extends Entity implements Shaman, Minion, Token {

    /** {@inheritDoc} */
    protected $rarity = Entity::RARITY_COMMON;

    /** {@inheritDoc} */
    protected $baseCost = 1;

    /** {@inheritDoc} */
    protected $name = 'Stoneclaw Totem';

    /** {@inheritDoc} */
    protected $baseAttack = 0;

    /** {@inheritDoc} */
    protected $baseHealth = 2;

}