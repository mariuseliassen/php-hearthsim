<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 23 12 2015
 */
namespace PHPHearthSim\Event\Entity;

use PHPHearthSim\Event\EntityEvent;
use PHPHearthSim\Model\Entity;

/**
 * Event when entities receive healing
 *
 * @class EntityReceiveHealEvent
 */
class EntityReceiveHealEvent extends EntityEvent {

    /**
     * Construct new EntityReceiveHealEvent
     *
     * @param \PHPHearthSim\Model\Entity $entity
     * @param mixed $eventData
     */
    public function __construct(Entity $entity = null, $eventData = null) {
        parent::__construct(EntityEvent::EVENT_ENTITY_RECEIVE_HEAL, $eventData, $entity);
    }

}