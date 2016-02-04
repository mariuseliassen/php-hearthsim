<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015-2016 Switchback
 * @date: 04 02 2016
 */
namespace PHPHearthSim\Tests\TestCase;

use PHPHearthSim\Tests\TestCase;
use PHPHearthSim\Game\Hero\Shaman\Thrall;
use PHPHearthSim\Game\Hero\Warrior\GarroshHellscream;

class ShamanVsWarriorTestCase extends TestCase {

    protected function setUp() {
        parent::setUp();

        // Update heroes to Shaman vs Warrior
        $this->board->getMe()->setHero(new Thrall()); // Shaman hero
        $this->board->getOpponent()->setHero(new GarroshHellscream()); // Warrior hero

        // Update hero and hero power references
        $this->board->updatePlayers();
    }

}
