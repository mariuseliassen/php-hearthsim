<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015-2016 Switchback
 * @date: 10 02 2016
 */
namespace PHPHearthSim\Tests;

use PHPHearthSim\Game\Spell\T\TheCoin;

class SpellTest extends TestCase
{

    public function testSpell()
    {
        $entity = new TheCoin(['board' => $this->board]);

        // Test interface
        $this->assertInstanceOf('PHPHearthSim\\Model\\Spell', $entity);
        // Test id
        $this->assertEquals('ENT_0001', $entity->getId());
        // Test name
        $this->assertEquals('The Coin', $entity->getName());
        // Test cost
        $this->assertEquals(0, $entity->getBaseCost());

    }

}
