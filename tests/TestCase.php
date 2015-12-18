<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 15 12 2015
 */
namespace PHPHearthSim\Tests;

use PHPHearthSim\Model\Board;
use PHPHearthSim\Model\Player;
use PHPHearthSim\Game\Hero\Warrior\GarroshHellscream;

abstract class TestCase extends \PHPUnit_Framework_TestCase {

    /** @var \PHPHearthSim\Model\Board */
    protected $board;

    /** @var \PHPHearthSim\Model\Board */
    protected $emptyBoard;

    /**
     * Setup stuff
     */
    protected function setUp() {
        // Create players
        $me = new Player();
        $me->setId(1);
        $me->setName('Switchback');
        $me->setHero(new GarroshHellscream()); // Warrior hero

        $opponent = new Player();
        $opponent->setId(2);
        $opponent->setName('SMOrcThaBork');
        $opponent->setHero(new GarroshHellscream()); // Warrior hero

        // Create board
        $this->board = new Board($me, $opponent);

        // Create empty board
        $this->emptyBoard = new Board($me, $opponent);
    }

}