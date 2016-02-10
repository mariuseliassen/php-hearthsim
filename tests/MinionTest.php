<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
namespace PHPHearthSim\Tests;

use PHPHearthSim\Game\Minion\Z\ZombieChow;

class MinionTest extends TestCase
{

    public function testMinion()
    {
        $entity = new ZombieChow(['board' => $this->board]);

        // Test interface
        $this->assertInstanceOf('PHPHearthSim\\Model\\Minion', $entity);
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
