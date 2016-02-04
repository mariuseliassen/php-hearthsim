<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015-2016 Switchback
 * @date: 04 02 2016
 */
namespace PHPHearthSim\Tests\Game\HeroPower\Shaman;

use PHPHearthSim\Model\Board;
use PHPHearthSim\Tests\TestCase\ShamanVsWarriorTestCase;
use PHPHearthSim\Game\Minion\Z\ZombieChow;

class TotemicCallTest extends ShamanVsWarriorTestCase {

    public function testHeroPowerInstance() {
        // Test TotemicCall instance
        $this->assertInstanceOf('PHPHearthSim\\Game\\HeroPower\\Shaman\\TotemicCall',
                                $this->board->getMe()->getHero()->getHeroPower());
    }

    public function testSummonRandomTotemOnEmptyBoard() {
        // Make sure that battlefield is empty
        $this->assertEquals(0, count($this->board->getBattlefieldForPlayer($this->board->getMe())));

        // Use hero power, don't need a target for this one
        $this->board->getMe()->getHero()->useHeroPower();

        // Make sure that battlefield contains 1 minion
        $this->assertEquals(1, count($this->board->getBattlefieldForPlayer($this->board->getMe())));

        // Test that index 0 is a searing totem
        $this->assertInstanceOf('PHPHearthSim\\Game\\Token\\S\\SearingTotem',
                                $this->board->getMinionOnBattlefieldAtPosition($this->board->getMe(), 0));

    }

    private function createAndExpect($count, $instanceName) {
        // Use hero power, don't need a target for this one
        $this->board->getMe()->getHero()->useHeroPower();

        // Make sure that battlefield contains correct number of minion(s)
        $this->assertEquals($count, count($this->board->getBattlefieldForPlayer($this->board->getMe())));

        // Test that index is a searing totem
        if ($instanceName != null) {
            $this->assertInstanceOf($instanceName,
                            $this->board->getMinionOnBattlefieldAtPosition($this->board->getMe(), $count - 1));
        }

    }

    public function testSummonFourRandomTotems() {
        // Make sure that battlefield is empty
        $this->assertEquals(0, count($this->board->getBattlefieldForPlayer($this->board->getMe())));

        // Create and expect 1
        $this->createAndExpect(1, 'PHPHearthSim\\Game\\Token\\S\\SearingTotem');

        // End turn 1
        $this->board->endTurn();

        // Create and expect 2
        $this->createAndExpect(2, 'PHPHearthSim\\Game\\Token\\W\\WrathOfAirTotem');

        // End turn 2
        $this->board->endTurn();

        // Create and expect 3
        $this->createAndExpect(3, 'PHPHearthSim\\Game\\Token\\H\\HealingTotem');

        // End turn 3
        $this->board->endTurn();

        // Create and expect 4
        $this->createAndExpect(4, 'PHPHearthSim\\Game\\Token\\S\\StoneclawTotem');

        // End turn 4
        $this->board->endTurn();
    }

    public function testSummonFiveRandomTotemsWhereLastOneIsNotSummoned() {
        // Test for summoning 4
        $this->testSummonFourRandomTotems();

        // Create and expect 4 still because no unique totems can be created anymore
        $this->createAndExpect(4, null);


    }

    public function testSummonRandomTotemOnFullBoard() {
        // Make sure that battlefield is empty
        $this->assertEquals(0, count($this->board->getBattlefieldForPlayer($this->board->getMe())));

        // Add 7 minions
        for ($i = 0; $i < Board::MAX_BATTLEFIELD_SIZE; $i++) {
            $this->board->addToBattlefield(new ZombieChow(), $this->board->getMe());
        }

        // Make sure that battlefield count is 7
        $this->assertEquals(Board::MAX_BATTLEFIELD_SIZE, count($this->board->getBattlefieldForPlayer($this->board->getMe())));

        // Use hero power, don't need a target for this one
        $this->board->getMe()->getHero()->useHeroPower();

        // Make sure that battlefield count is still 7
        $this->assertEquals(Board::MAX_BATTLEFIELD_SIZE, count($this->board->getBattlefieldForPlayer($this->board->getMe())));

    }

}