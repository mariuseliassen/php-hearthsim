<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
namespace PHPHearthSim\Model\Mechanic;

/**
 * Interface for Deathrattle
 *
 * @author Marius
 * @class DeathrattleInterface
 *
 */
interface DeathrattleInterface {

    /**
     * Trigger for deathrattle
     */
    public function deathrattle();

}