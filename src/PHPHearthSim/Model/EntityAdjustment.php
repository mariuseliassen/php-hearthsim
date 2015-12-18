<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
namespace PHPHearthSim\Model;

/**
 * Class to hold adjustment information for a entity
 * This includes buffs, debuffs and/or attack sequences that modify health or attack or other card states
 *
 * @class EntityAdjustment
 */
class EntityAdjustment {

    /**
     * This adjustment is used when modifying health up or down by a value
     *
     * @var string
     */
    const ADJUSTMENT_HEALTH = 'adjustment.health';

    /**
     * Set health to a specific value
     *
     * @var string
     */
    const SET_HEALTH = 'set.health';

    /**
     * This adjustment is used when modifying attack up or down by a value
     *
     * @var string
     */
    const ADJUSTMENT_ATTACK = 'adjustment.attack';

    /**
     * Set attack to a specific value
     *
     * @var string
     */
    const SET_ATTACK = 'set.attack';

    /**
     * Type of adjustment. See constants defined in this class.
     *
     * @var string
     */
    protected $type;

    /**
     * The amount/value that has changed. Value format depends on $type
     *
     * @var mixed
     */
    protected $value;


    /**
     * Construct new adjustment
     *
     * @param string $type See constant values
     * @param mixed $value
     */
    public function __construct($type, $value) {
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * Set adjustment type
     *
     * @param string $type
     * @return \PHPHearthSim\Model\EntityAdjustment
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get adjustment type
     *
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set adjustment value
     *
     * @param mixed $value
     * @return \PHPHearthSim\Model\EntityAdjustment
     */
    public function setValue($value) {
        $this->value = $value;

        return $this;
    }

    /**
     * Get adjustment value
     *
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

}