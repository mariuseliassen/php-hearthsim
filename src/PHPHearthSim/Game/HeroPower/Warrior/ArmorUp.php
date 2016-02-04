<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 18 12 2015
 */
namespace PHPHearthSim\Game\HeroPower\Warrior;

use PHPHearthSim\Model\Entity;
use PHPHearthSim\Model\HeroPower;

/**
 * Armor Up!
 * Gain 2 armor
 *
 * @class ArmorUp
 */
class ArmorUp extends HeroPower {

    /** {@inheritDoc} */
    protected $name = 'Armor Up!';

    /**
     * Hero power:
     * Gain 2 armor
     *
     * @param \PHPHearthSim\Model\Entity $target
     * @return \PHPHearthSim\Game\HeroPower\Warrior\ArmorUp
     * */
    public function useOn(Entity $target = null) {
        // Call parent to update usage, etc
        parent::useOn($target);

        // Gain 2 armor
        $this->getHero()->gainArmor(2);

        return $this;
    }

}