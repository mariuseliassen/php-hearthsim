<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
namespace PHPHearthSim\Model\Mechanic;

use PHPHearthSim\Model\Entity;

/**
 * Interface for Deathrattle
 *
 * @author Switchback
 * @class Deathrattle
 *
 */
interface Deathrattle {

    /**
     * Execute deathrattle
     */
    public function execute(Entity $entity);

}