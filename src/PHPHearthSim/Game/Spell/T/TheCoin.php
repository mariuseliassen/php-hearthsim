<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015-2016 Switchback
 * @date: 10 02 2016
 */
namespace PHPHearthSim\Game\Spell\T;

use PHPHearthSim\Model\EntityClass\Neutral;
use PHPHearthSim\Model\Spell;
use PHPHearthSim\Model\Entity;
use PHPHearthSim\Model\Set\Basic;

/**
 * The Coin
 * Unique spell
 *
 * "Gain 1 Mana Crystal this turn only."
 *
 * @class TheCoin
 */
class TheCoin extends Spell implements Neutral, Basic {

    /** {@inheritDoc} */
    protected $rarity = Entity::RARITY_UNIQUE;

    /** {@inheritDoc} */
    protected $baseCost = 0;

    /** {@inheritDoc} */
    protected $name = 'The Coin';

    /** {@inheritDoc} */
    public function play(Entity $target = null) {
        // Gain 1 temporary mana crystal
        $this->getOwner()->gainManaCrystals(1, true, true);

        return $this;
    }

}