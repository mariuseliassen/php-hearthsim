<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
namespace PHPHearthSim\Event\Entity;

use PHPHearthSim\Event\EntityEvent;
use PHPHearthSim\Model\Entity;

/**
 * Event when entities are created
 *
 * @class EntityCreateEvent
 */
class EntityCreateEvent extends EntityEvent {

    /**
     * Construct new EntityCreateEvent
     *
     * @param \PHPHearthSim\Model\Entity $entity
     */
    public function __construct(Entity $entity) {
        parent::__construct(EntityEvent::EVENT_ENTITY_CREATE, $entity);
    }

}