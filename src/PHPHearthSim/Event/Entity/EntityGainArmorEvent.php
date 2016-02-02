<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015-2016 Switchback
 * @date: 02 02 2016
 */
namespace PHPHearthSim\Event\Entity;

use PHPHearthSim\Event\EntityEvent;
use PHPHearthSim\Model\Entity;

/**
 * Event when entities gain armor
 *
 * @class EntityGainArmorEvent
 */
class EntityGainArmorEvent extends EntityEvent {

    /**
     * Construct new EntityGainArmorEvent
     *
     * @param \PHPHearthSim\Model\Entity $entity
     * @param mixed $eventData
     */
    public function __construct(Entity $entity = null, $eventData = null) {
        parent::__construct(EntityEvent::EVENT_ENTITY_GAIN_ARMOR, $eventData, $entity);
    }

}