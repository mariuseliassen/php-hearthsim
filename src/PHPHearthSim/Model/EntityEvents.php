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

/**
 * Helper abstract class for entity events to help reduce the number of methods on Entity class
 *
 * @class EntityEvents
 */
abstract class EntityEvents {

    /**
     * Event for handling when other entites are created
     *
     * @param \PHPHearthSim\Event\EntityEvent $event
     * @return \PHPHearthSim\Model\EntityEvents;
     */
    public function onEntityCreateEvent(EntityCreateEvent $event) {
        return $this;
    }
}

