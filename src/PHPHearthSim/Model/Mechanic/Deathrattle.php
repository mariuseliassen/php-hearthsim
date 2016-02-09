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
     *
     * @param Entity $entity The entity that triggered the deathrattle
     * @return void
     */
    public function execute(Entity $entity);

}