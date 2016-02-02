<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015-2016 Switchback
 * @date: 02 02 2016
 */
namespace PHPHearthSim\Tests\Game\HeroPower;

use PHPHearthSim\Tests\TestCase\PriestVsWarriorTestCase;

class HeroPowerTest extends PriestVsWarriorTestCase {

    public function testHeroPowerInstance() {
        // Test HeroPower instance
        $this->assertInstanceOf('PHPHearthSim\\Model\\HeroPower',
                                $this->board->getOpponent()->getHero()->getHeroPower());
    }

    public function testHeroPowerCanOnlyBeUsedOnceEachTurn() {
        $this->setExpectedException('PHPHearthSim\Exception\HeroPower\HeroPowerAlreadyUsedThisTurnException');

        // Use hero power once
        $this->board->getOpponent()->getHero()->useHeroPower();

        // Attempt to use hero power twice, should throw exception
        $this->board->getOpponent()->getHero()->useHeroPower();
    }
}