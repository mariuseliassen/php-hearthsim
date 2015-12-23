<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 23 12 2015
 */
namespace PHPHearthSim\Tests\Game\Minion\A;

use PHPHearthSim\Model\Entity;
use PHPHearthSim\Game\Minion\A\AuchenaiSoulpriest;
use PHPHearthSim\Tests\TestCase;

class AuchenaiSoulpriestTest extends TestCase {

    protected $entity;

    protected function setUp() {
        parent::setUp();

        $this->entity = new AuchenaiSoulpriest(['board' => $this->emptyBoard,
                                                'owner' => $this->emptyBoard->getMe() // Set me as owner of card
        ]);
    }

    public function testCardData() {
        // Test Minion instance
        $this->assertInstanceOf('PHPHearthSim\\Model\\Minion', $this->entity);
        // Test EntityClass instance
        $this->assertInstanceOf('PHPHearthSim\\Model\\EntityClass\\Priest', $this->entity);
        // Test name
        $this->assertEquals('Auchenai Soulpriest', $this->entity->getName());
        // Test cost
        $this->assertEquals(4, $this->entity->getBaseCost());
        // Test health and attack
        $this->assertEquals(3, $this->entity->getBaseAttack());
        $this->assertEquals(5, $this->entity->getBaseHealth());
        // Test rarity
        $this->assertEquals(Entity::RARITY_RARE, $this->entity->getRarity());
    }

}