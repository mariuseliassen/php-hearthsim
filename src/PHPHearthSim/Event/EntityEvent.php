<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
namespace PHPHearthSim\Event;

use PHPHearthSim\Model\Entity;
use Symfony\Component\EventDispatcher\Event;

/**
 * Abstract class to derive event handling
 *
 * @class EntityEvent
 * @property-read \PHPHearthSim\Model\Entity $entity get the event entity
 */
abstract class EntityEvent extends Event {

    /**
     * Constant for entity create event
     *
     * @var string
     */
    const EVENT_ENTITY_CREATE = 'entity.create';

    /**
     * Name of event called
     * 
     * @var string
     */
    protected $eventName;
    
    /**
     * Entity for event
     *
     * @var \PHPHearthSim\Model\Entity;
     */
    protected $entity;

    /**
     * Construct new EntityEvent and set the entity
     *
     * @param string $eventName
     * @param \PHPHearthSim\Model\Entity $entity
     */
    public function __construct($eventName, Entity $entity) {
        $this->eventName = $eventName;
        $this->entity = $entity;
    }
    
    /**
     * Get event name
     * 
     * @return string
     */
    public function getEventName() {
        return $this->eventName;
    }

    /**
     * Get the entity
     *
     * @return \PHPHearthSim\Model\Entity;
     */
    public function getEntity() {
        return $this->entity;
    }

}