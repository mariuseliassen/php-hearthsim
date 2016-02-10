<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 24 12 2015
 */
namespace PHPHearthSim\Tests\Game\Mechanic;

use PHPHearthSim\Game\Minion\Z\ZombieChow;
use PHPHearthSim\Game\Mechanic\Deathrattle\Z\ZombieChowDeathrattle;
use PHPHearthSim\Tests\TestCase;

class DeathrattleTest extends TestCase {

    public function testDeathrattle() {
        $entity = new ZombieChow(['board' => $this->board,
                                  'owner' => $this->board->getMe()]);

        // Test deathrattle interface
        $this->assertInstanceOf('PHPHearthSim\\Model\\Mechanic\\Deathrattle', $entity->getDeathrattleByIndex(0));

        // Test hasDeathrattle() method
        $entity->hasDeathrattle(new ZombieChowDeathrattle());

        // Hero take some damage, from 30 (base) - 10 = 20.
        $this->board->getOpponent()->getHero()->takeDamage(10);

        // Assert that enemy hero health is 20
        $this->assertEquals(20, $this->board->getOpponent()->getHero()->getHealth());

        // Destroy minion, triggering the deathrattle in the same process
        $entity->destroy();

        // Assert that enemy hero health is 5 more == 25
        $this->assertEquals(25, $this->board->getOpponent()->getHero()->getHealth());
    }

    public function testDeathrattleNotTriggeringWhenSilenced() {
        $entity = new ZombieChow(['board' => $this->board,
                                  'owner' => $this->board->getMe()]);

        // Hero take some damage, from 30 (base) - 10 = 20.
        $this->board->getOpponent()->getHero()->takeDamage(10);

        // Assert that enemy hero health is 20
        $this->assertEquals(20, $this->board->getOpponent()->getHero()->getHealth());

        // Silence minion
        $entity->silence();

        // Destroy minion, deathrattle should not trigger now
        $entity->destroy();

        // Assert that enemy hero health is the same == 20
        $this->assertEquals(20, $this->board->getOpponent()->getHero()->getHealth());
    }
}