<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 18 12 2015
 */
namespace PHPHearthSim\Event\Entity;

use PHPHearthSim\Event\EntityEvent;
use PHPHearthSim\Model\Entity;

/**
 * Event when entities take damage
 *
 * @class EntityTakeDamageEvent
 */
class EntityTakeDamageEvent extends EntityEvent {

    /**
     * Construct new EntityTakeDamageEvent
     *
     * @param \PHPHearthSim\Model\Entity $entity
     * @param mixed $eventData
     */
    public function __construct(Entity $entity = null, $eventData = null) {
        parent::__construct(EntityEvent::EVENT_ENTITY_TAKE_DAMAGE, $eventData, $entity);
    }

}