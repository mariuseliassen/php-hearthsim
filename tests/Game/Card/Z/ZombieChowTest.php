<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 15 12 2015
 */
namespace PHPHearthSim\Tests\Game\Card\Z;

use PHPHearthSim\Game\Card\Z\ZombieChow;
use PHPHearthSim\Tests\TestCase;

class ZombieChowTest extends TestCase {

    protected $entity;

    protected function setUp() {
        parent::setUp();

        $this->entity = new ZombieChow(['board' => $this->emptyBoard,
                                        'owner' => $this->emptyBoard->getMe() // Set me as owner of card
        ]);
    }

    public function testCardData() {
        // Test name
        $this->assertEquals('Zombie Chow', $this->entity->getName());
        // Test cost
        $this->assertEquals(1, $this->entity->getBaseCost());
        // Test health and attack
        $this->assertEquals(2, $this->entity->getBaseAttack());
        $this->assertEquals(3, $this->entity->getBaseHealth());
        // Test rarity
        $this->assertEquals('Basic', $this->entity->getRarity());
    }

    public function testDeathrattle() {
        // Test deathrattle interface
        $this->assertInstanceOf('PHPHearthSim\\Model\\Mechanic\\DeathrattleInterface', $this->entity);

        // Hero take some damage, from 30 (base) - 10 = 20.
        $this->emptyBoard->getOpponent()->getHero()->takeDamage(10);

        // Destroy minion, triggering the deathrattle in the same process
        $this->entity->destroy();

        // Assert that opponent health is 5 more == 25
        $this->assertEquals(25, $this->emptyBoard->getOpponent()->getHero()->getHealth());

    }

}