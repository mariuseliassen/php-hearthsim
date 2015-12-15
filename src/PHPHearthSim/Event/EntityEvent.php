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
     * Entity for event
     *
     * @var \PHPHearthSim\Model\Entity;
     */
    protected $entity;

    /**
     * Construct new EntityEvent and set the entity
     *
     * @param \PHPHearthSim\Model\Entity $entity
     */
    public function __construct(Entity $entity) {
        $this->entity = $entity;
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