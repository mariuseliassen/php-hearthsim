<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015-2016 Switchback
 * @date: 10 02 2016
 */
namespace PHPHearthSim\Model;

use PHPHearthSim\Model\Entity;

/**
 * Spell.
 * This class contains mechanic for playing spells
 *
 * @class Spell
 */
abstract class Spell extends Entity {

    /**
     * Play the spell. Each Spell will implement this function to do something special.
     *
     * @param Entity|null $target The target for the spell
     *
     * @return \PHPHearthSim\Model\Spell
     */
    public function play(Entity $target = null) {
        return $this;
    }

}