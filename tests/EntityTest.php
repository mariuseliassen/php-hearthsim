<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
namespace PHPHearthSim\Tests;

use PHPHearthSim\Game\Card\Z\ZombieChow;
use PHPHearthSim\Model\Board;
use PHPHearthSim\Model\Player;

class EntityTest extends TestCase
{

    /**
     * Tests the basic methods of Entity class
     */
    public function testEntity()
    {
        $entity = new ZombieChow(['board' => $this->board]);

        // Test id
        $this->assertEquals('ENT_0001', $entity->getId());
        // Test name
        $this->assertEquals('Zombie Chow', $entity->getName());
        // Test cost
        $this->assertEquals(1, $entity->getBaseCost());
        // Test health and attack
        $this->assertEquals(2, $entity->getBaseAttack());
        $this->assertEquals(3, $entity->getBaseHealth());
    }

}
