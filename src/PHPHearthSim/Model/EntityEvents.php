<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 14 12 2015
 */
namespace PHPHearthSim\Model;

use PHPHearthSim\Event\Entity\EntityCreateEvent;
use PHPHearthSim\Event\Board\BoardTurnStartEvent;

/**
 * Helper abstract class for entity events to help reduce the number of methods on Entity class
 *
 * @class EntityEvents
 */
abstract class EntityEvents {

    /**
     * Constructor
     */
    public function __construct() {

    }

    /**
     * Event for handling when board turn starts
     *
     * @param \PHPHearthSim\Event\Board\BoardTurnStartEvent $event
     * @return \PHPHearthSim\Model\EntityEvents;
     */
    public function onBoardTurnStart(BoardTurnStartEvent $event) {
        return $this;
    }

    /**
     * Event for handling when other entites are created
     *
     * @param \PHPHearthSim\Event\Entity\EntityCreateEvent $event
     * @return \PHPHearthSim\Model\EntityEvents;
     */
    public function onEntityCreateEvent(EntityCreateEvent $event) {
        return $this;
    }
}

