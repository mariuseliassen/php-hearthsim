<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
namespace PHPHearthSim\Tests\TestCase;

use PHPHearthSim\Tests\TestCase;
use PHPHearthSim\Game\Hero\Priest\AnduinWrynn;
use PHPHearthSim\Game\Hero\Warrior\GarroshHellscream;

class PriestVsWarriorTestCase extends TestCase {

    protected function setUp() {
        parent::setUp();

        // Update heroes to Priest vs Warrior
        $this->board->getMe()->setHero(new AnduinWrynn()); // Priest hero
        $this->board->getOpponent()->setHero(new GarroshHellscream()); // Warrior hero

        $this->emptyBoard->getMe()->setHero(new AnduinWrynn()); // Priest hero
        $this->emptyBoard->getOpponent()->setHero(new GarroshHellscream()); // Warrior hero

        // Update hero and hero power references
        $this->emptyBoard->updatePlayers();
    }

}
