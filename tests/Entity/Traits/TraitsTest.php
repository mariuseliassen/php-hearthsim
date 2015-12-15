<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
namespace Entity\Traits;

use PHPHearthSim\Game\Card\Z\ZombieChow;

class TraitsTest extends \PHPUnit_Framework_TestCase
{

    public function testBasicRarityTrait()
    {
        $entity = new ZombieChow();

        $this->assertEquals('Basic', $entity->getRarity());
    }

}
