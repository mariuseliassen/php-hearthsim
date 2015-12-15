<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
use PHPHearthSim\Model\Player;

class PlayerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests the basic methods of Entity class
     */
    public function testPlayer()
    {
        $player = new Player();
        $player->setId(1);
        $player->setName('Switchback');

        $this->assertEquals($player->getId(), 1);
        $this->assertEquals($player->getName(), 'Switchback');

        // TODO: test deck
        // TODO: test hero
    }

}
