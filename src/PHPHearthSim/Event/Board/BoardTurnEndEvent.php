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
 * Event when board end turn event triggers
 *
 * @class BoardTurnEndEvent
 */
class BoardTurnEndEvent extends EntityEvent {

    /**
     * Construct new BoardTurnEndEvent
     *
     * @param mixed $eventData
     */
    public function __construct($eventData = null) {
        parent::__construct(EntityEvent::EVENT_BOARD_TURN_END, $eventData);
    }

}