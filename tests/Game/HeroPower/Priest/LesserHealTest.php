<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015-2016 Switchback
 * @date: 04 02 2016
 */
namespace PHPHearthSim\Tests\Game\HeroPower\Priest;

use PHPHearthSim\Game\Minion\Z\ZombieChow;
use PHPHearthSim\Tests\TestCase\PriestVsWarriorTestCase;

class LesserHealTest extends PriestVsWarriorTestCase {

    public function testHeroPowerInstance() {
        // Test LesserHeal instance
        $this->assertInstanceOf('PHPHearthSim\\Game\\HeroPower\\Priest\\LesserHeal',
                                $this->board->getMe()->getHero()->getHeroPower());
    }

    public function testLesserHealOnMinion() {
        // Create a zombie chow
        $entity = new ZombieChow(['board' => $this->board,
                                  'owner' => $this->board->getMe()]);

        // Minion take 2 damage
        $entity->takeDamage(2);

        // Make sure health == 1 (3-2)
        $this->assertEquals(1, $entity->getHealth());

        // Use the hero power
        $this->board->getMe()->getHero()->useHeroPower($entity);

        // Make sure health == 3
        $this->assertEquals(3, $entity->getHealth());
    }

    public function testLesserHealOnHero() {
        // Minion take 2 damage
        $this->board->getMe()->getHero()->takeDamage(4);

        // Make sure health == 26
        $this->assertEquals(26, $this->board->getMe()->getHero()->getHealth());

        // Use the hero power
        $this->board->getMe()->getHero()->useHeroPower($this->board->getMe()->getHero());

        // Make sure health == 28
        $this->assertEquals(28, $this->board->getMe()->getHero()->getHealth());
    }

    public function testLesserHealOnHeroWithFullHealth() {
        // Make sure health == 30
        $this->assertEquals(30, $this->board->getMe()->getHero()->getHealth());

        // Use the hero power
        $this->board->getMe()->getHero()->useHeroPower($this->board->getMe()->getHero());

        // Make sure health == 30
        $this->assertEquals(30, $this->board->getMe()->getHero()->getHealth());
    }

}