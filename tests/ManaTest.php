<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015-2016 Switchback
 * @date: 07 02 2016
 */
namespace PHPHearthSim\Tests;

class ManaTest extends TestCase
{

    public function testManaCrystalsEndTurn()
    {
        // Make sure both players start with 1 mana and have 1 mana available
        $this->assertEquals(1, $this->board->getMe()->getTurnStartMana());
        $this->assertEquals(1, $this->board->getMe()->getAvailableMana());

        $this->assertEquals(1, $this->board->getOpponent()->getTurnStartMana());
        $this->assertEquals(1, $this->board->getOpponent()->getAvailableMana());

        // End turn 1
        $this->board->endTurn();

        // Check mana for turn 2
        $this->assertEquals(2, $this->board->getMe()->getTurnStartMana());
        $this->assertEquals(2, $this->board->getMe()->getAvailableMana());

        // Turns 3-10
        $this->endTurnAndValidate(3);
        $this->endTurnAndValidate(4);
        $this->endTurnAndValidate(5);
        $this->endTurnAndValidate(6);
        $this->endTurnAndValidate(7);
        $this->endTurnAndValidate(8);
        $this->endTurnAndValidate(9);
        $this->endTurnAndValidate(10);

        // Turn 11, should still be 10 mana
        $this->endTurnAndValidate(10);

    }

    public function testUseManaCrystals() {
        // Give player 5 mana
        $this->board->getMe()->setAvailableMana(5);

        // Make sure available mana is 5
        $this->assertEquals(5, $this->board->getMe()->getAvailableMana());

        // Make sure we can afford to play a 3 cost card
        $this->assertTrue($this->board->getMe()->canAffordToPlay(3));

        // Use 3 mana
        $this->board->getMe()->useMana(3);

        // Make sure available mana is now 2
        $this->assertEquals(2, $this->board->getMe()->getAvailableMana());
    }

    public function testUseManaCrystalsNotEnoughManaException() {
        $this->setExpectedException('PHPHearthSim\Exception\Player\NotEnoughManaException');

        // Give player 5 mana
        $this->board->getMe()->setAvailableMana(5);

        // Make sure available mana is 5
        $this->assertEquals(5, $this->board->getMe()->getAvailableMana());

        // Use 6 mana, this should throw exception
        $this->board->getMe()->useMana(6);
    }

    public function testUseManaCrystalsDoubleNotEnoughManaException() {
        $this->setExpectedException('PHPHearthSim\Exception\Player\NotEnoughManaException');

        // Give player 5 mana
        $this->board->getMe()->setAvailableMana(5);

        // Make sure available mana is 5
        $this->assertEquals(5, $this->board->getMe()->getAvailableMana());

        // Make sure we can afford to play a 3 cost card
        $this->assertTrue($this->board->getMe()->canAffordToPlay(3));

        // Use 3 mana
        $this->board->getMe()->useMana(3);

        // Use 6 mana, this should throw exception
        $this->board->getMe()->useMana(3);
    }


    public function testManaCrystalsWithLockedCrystals() {
        // Give player 5 mana
        $this->board->getMe()->setAvailableMana(5);
        // Overload 2 of those mana crystals
        $this->board->getMe()->setLockedMana(2);

        // Make sure available mana is 5
        $this->assertEquals(3, $this->board->getMe()->getAvailableMana());
    }

    public function testManaCrystalsWithLockedCrystalsNextTurn() {
        // Simulate some board turns
        $this->endTurnAndValidate(2);
        $this->endTurnAndValidate(3);
        $this->endTurnAndValidate(4);

        $this->board->endTurn();

        // Simulate a overload this turn
        $this->board->getMe()->queueLockedMana(3);

        // End my turn
        $this->board->endTurn();
        // End opponent turn
        $this->board->endTurn();

        // Now on my turn again i should have less available mana
        $this->assertEquals(3, $this->board->getMe()->getLockedMana());
        $this->assertEquals(3, $this->board->getMe()->getAvailableMana());
        $this->assertEquals(6, $this->board->getMe()->getTurnStartMana());

    }

    /**
     * Helper method to check mana for end turn for a player
     *
     * @param int $expectedMana
     */
    private function endTurnAndValidate($expectedMana) {
        $this->board->endTurn();
        $this->board->endTurn();

        $this->assertEquals($expectedMana, $this->board->getMe()->getTurnStartMana());
        $this->assertEquals($expectedMana, $this->board->getMe()->getAvailableMana());
    }

}
