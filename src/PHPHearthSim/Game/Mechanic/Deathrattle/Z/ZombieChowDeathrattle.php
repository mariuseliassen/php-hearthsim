<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015-2016 Switchback
 * @date: 09 02 2016
 */
namespace PHPHearthSim\Game\Mechanic\Deathrattle\Z;

use PHPHearthSim\Model\Mechanic\Deathrattle;
use PHPHearthSim\Model\Entity;

/**
 * Zombie Chow Deathrattle.
 * Restore 5 Health to the enemy hero.
 *
 * @class ZombieChowDeathrattle
 */
class ZombieChowDeathrattle implements Deathrattle {

    /** {@inheritDoc} */
    public function execute(Entity $entity) {
        $entity->getEnemyHero()->healFor(5, $entity);
    }

}