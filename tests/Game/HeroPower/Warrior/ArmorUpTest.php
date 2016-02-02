<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015-2016 Switchback
 * @date: 02 02 2016
 */
namespace PHPHearthSim\Tests\Game\HeroPower\Warrior;

use PHPHearthSim\Tests\TestCase\PriestVsWarriorTestCase;

class ArmorUpTest extends PriestVsWarriorTestCase {

    public function testHeroPower() {
        // Test ArmorUp instance
        $this->assertInstanceOf('PHPHearthSim\\Game\\HeroPower\\Warrior\\ArmorUp',
                                $this->board->getOpponent()->getHero()->getHeroPower());
    }

    public function testGainArmorWithHeroPower() {
        // Make sure that armor equals 0
        $this->assertEquals(0, $this->board->getOpponent()->getHero()->getArmor());

        // Use the hero power, we don't need a target for this one
        $this->board->getOpponent()->getHero()->useHeroPower();

        // Make sure that armor equals 2
        $this->assertEquals(2, $this->board->getOpponent()->getHero()->getArmor());

    }

}