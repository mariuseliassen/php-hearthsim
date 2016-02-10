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

class BoardTest extends TestCase
{

    /**
     * Tests the basic methods of Board class
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

    public function testAddAndRemoveMinionFromBattlefieldMinionNotFoundAtPositionException() {
        // MinionNotFoundAtPositionException expected
        $this->setExpectedException('PHPHearthSim\\Exception\\Board\\MinionNotFoundAtPositionException');

        // Add a zombie chow to me
        $entity = new ZombieChow(['board' => $this->board, 'owner' => $this->board->getMe()]);

        // Add zombie chow to battlefield (pos 0 by default)
        $this->board->addToBattlefield($entity, $this->board->getMe());

        // Test getMinionOnBattlefieldAtPosition()
        $this->assertInstanceOf('PHPHearthSim\\Game\\Minion\\Z\\ZombieChow',
                $this->board->getMinionOnBattlefieldAtPosition($this->board->getMe(), 0));

        // Destroy minion, should automaticly be removed
        $entity->destroy();

        // This should throw MinionNotFoundAtPositionException now
        $this->board->getMinionOnBattlefieldAtPosition($this->board->getMe(), 0);
    }

}
