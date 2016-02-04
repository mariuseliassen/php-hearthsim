<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015-2016 Switchback
 * @date: 04 02 2016
 */
namespace PHPHearthSim\Game\HeroPower\Shaman;

use PHPHearthSim\Model\Entity;
use PHPHearthSim\Model\HeroPower;

/**
 * Totemic Call
 * Summon a random totem
 *
 * @class TotemicCall
 */
class TotemicCall extends HeroPower {

    /** {@inheritDoc} */
    protected $name = 'Totemic Call';

    /**
     * Hero power:
     * Summon a random totem
     *
     * @param \PHPHearthSim\Model\Entity $target
     * @return \PHPHearthSim\Game\HeroPower\Shaman\TotemicCall
     * */
    public function useOn(Entity $target = null) {
        // Call parent to update usage, etc
        parent::useOn($target);

        // TODO: summon a random totem

        return $this;
    }

}