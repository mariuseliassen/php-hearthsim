<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015-2016 Switchback
 * @date: 04 02 2016
 */
namespace PHPHearthSim\Event\Board;

use PHPHearthSim\Event\EntityEvent;

/**
 * Event when board start turn event triggers
 *
 * @class BoardTurnStartEvent
 */
class BoardTurnStartEvent extends EntityEvent {

    /**
     * Construct new BoardTurnStartEvent
     *
     * @param mixed $eventData
     */
    public function __construct($eventData = null) {
        parent::__construct(EntityEvent::EVENT_BOARD_TURN_START, $eventData);
    }

}