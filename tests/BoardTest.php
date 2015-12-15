<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
use PHPHearthSim\Model\Board;
use PHPHearthSim\Model\Player;

class BoardTest extends \PHPUnit_Framework_TestCase
{

    /** @var \PHPHearthSim\Model\Board */
    protected $board;

    /**
     * Setup stuff
     */
    protected function setUp() {
        // Create players
        $me = new Player();
        $me->setId(1);
        $me->setName('Switchback');

        $opponent = new Player();
        $opponent->setId(2);
        $opponent->setName('SMOrcThaBork');

        // Create board
        $this->board = new Board($me, $opponent);
    }

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
