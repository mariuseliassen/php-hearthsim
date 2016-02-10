<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015-2016 Switchback
 * @date: 10 02 2016
 */
namespace PHPHearthSim\Tests\Game\Spell\T;

use PHPHearthSim\Model\Entity;
use PHPHearthSim\Game\Spell\T\TheCoin;
use PHPHearthSim\Tests\TestCase;

class TheCoinTest extends TestCase {

    protected $entity;

    protected function setUp() {
        parent::setUp();

        $this->entity = new TheCoin(['board' => $this->board,
                                     'owner' => $this->board->getOpponent() // Set opponent as owner of card
        ]);
    }

    public function testCardData() {
        // Test Minion instance
        $this->assertInstanceOf('PHPHearthSim\\Model\\Spell', $this->entity);
        // Test EntityClass instance
        $this->assertInstanceOf('PHPHearthSim\\Model\\EntityClass\\Neutral', $this->entity);
        // Test name
        $this->assertEquals('The Coin', $this->entity->getName());
        // Test cost
        $this->assertEquals(0, $this->entity->getBaseCost());
        // Test rarity
        $this->assertEquals(Entity::RARITY_UNIQUE, $this->entity->getRarity());
    }

    public function testGainTmporaryManaCrystal() {
        // Make sure mana is 1 at beginning of turn for both players
        $this->assertEquals(1, $this->board->getOpponent()->getAvailableMana());
        $this->assertEquals(1, $this->board->getMe()->getAvailableMana());

        // Play the spell for "opponent"
        $this->entity->play();

        // Make sure only "opponent" gained mana and not opponent
        $this->assertEquals(2, $this->board->getOpponent()->getAvailableMana());
        $this->assertEquals(1, $this->board->getMe()->getAvailableMana());

        // Use 2 mana
        $this->board->getOpponent()->useMana(2);

        // Mana should now be 0 for opponent
        $this->assertEquals(0, $this->board->getOpponent()->getAvailableMana());

        // End turn
        $this->board->endTurn();

        // Mana only reset for "me", not opponent yet
        $this->assertEquals(0, $this->board->getOpponent()->getAvailableMana());
        $this->assertEquals(2, $this->board->getMe()->getAvailableMana());

        // End turn
        $this->board->endTurn();

        // Now finally mana is reset for "opponent", temporary mana is removed
        $this->assertEquals(2, $this->board->getOpponent()->getAvailableMana());
        $this->assertEquals(2, $this->board->getMe()->getAvailableMana());
    }

    public function testNotExceedingMaxManaWithTheCoin() {
        // Set opponent mana to 10
        $this->board->getOpponent()->setTurnStartMana(10);

        // End some turns to reset mana counters
        $this->board->endTurn();
        $this->board->endTurn();

        // Make sure opponent has 10 mana
        $this->assertEquals(10, $this->board->getOpponent()->getAvailableMana());

        // Play the spell for "opponent"
        $this->entity->play();

        // Make sure opponent still only has 10 mana
        $this->assertEquals(10, $this->board->getOpponent()->getAvailableMana());
    }
}