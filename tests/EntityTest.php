<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
use PHPHearthSim\Game\Card\Z\ZombieChow;
use PHPHearthSim\Model\Board;
use PHPHearthSim\Model\Player;

class EntityTest extends \PHPUnit_Framework_TestCase
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
    public function testEntity()
    {
        $entity = new ZombieChow(['board' => $this->board]);

        // Test id
        $this->assertEquals('ENT_0001', $entity->getId());
        // Test name
        $this->assertEquals('Zombie Chow', $entity->getName());
        // Test cost
        $this->assertEquals(1, $entity->getBaseCost());
        // Test health and attack
        $this->assertEquals(2, $entity->getBaseAttack());
        $this->assertEquals(3, $entity->getBaseHealth());
    }

}
