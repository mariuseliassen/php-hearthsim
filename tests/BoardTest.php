<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
namespace PHPHearthSim\Tests;

class BoardTest extends TestCase
{

    /**
     * Tests the basic methods of Entity class
     */
    public function testBoardPlayers()
    {
        // Make sure we can retrieve players
        $this->assertEquals($this->board->getMe()->getName(), 'Switchback');
        $this->assertEquals($this->board->getOpponent()->getName(), 'SMOrcThaBork');
        // Test board reference
        $this->assertInstanceOf('PHPHearthSim\Model\Board', $this->board->getMe()->getBoard());
        $this->assertInstanceOf('PHPHearthSim\Model\Board', $this->board->getOpponent()->getBoard());
    }


}
