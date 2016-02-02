<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 23 12 2015
 */
namespace PHPHearthSim\Game\HeroPower\Priest;

use PHPHearthSim\Model\HeroPower;
use PHPHearthSim\Model\Entity;

/**
 * Lesser Heal
 * Restore 2 health
 *
 * @class LesserHeal
 */
class LesserHeal extends HeroPower {

    /** {@inheritDoc} */
    protected $name = 'Lesser Heal';

    /**
     * Constructor
     *
     * @param array $options Options to set during initialization
     */
    public function __construct(array $options = []) {
        // Call the parent constructor to set up events, etc.
        parent::__construct($options);
    }

    /**
     * Hero power:
     * Restore 2 health
     *
     * @param \PHPHearthSim\Model\Entity $target
     * @return \PHPHearthSim\Game\HeroPower\Priest\LesserHeal
     * */
    public function useOn(Entity $target) {
        // Call parent to update usage, etc
        parent::useOn($target);

        // Heal target for 2
        $target->healFor(2, $this);

        return $this;
    }

}