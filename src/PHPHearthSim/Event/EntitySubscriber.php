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
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Subscription manager for entities
 * This class handles the interaction between entites when certain events are triggered
 *
 * @class EntitySubscriber
 * @property-write \PHPHearthSim\Model\Entity $entity set the entity model
 */
class EntitySubscriber implements EventSubscriberInterface {

    /**
     * The entity that is subscribing
     *
     * @var \PHPHearthSim\Model\Entity
     */
    protected $entity;

    /**
     * Get the events that this entity want to subscribe to
     *
     * @return mixed
     */
    public static function getSubscribedEvents()
    {
        $events = [];

        // All entities should be notified about entity creation
        $events[EntityEvent::EVENT_ENTITY_CREATE] = ['onEntityCreate', 0];

        // TODO: check if has deathrattle, battlecry, etc...

        return $events;
    }

    /**
     * Set the subscription entity
     *
     * @param \PHPHearthSim\Model\Entity $entity
     * @return \PHPHearthSim\Event\EntitySubscriber
     */
    public function setEntity(Entity $entity) {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Event handler for entity create
     *
     * @param \PHPHearthSim\Event\EntityEvent $event
     * @return void
     */
    public function onEntityCreate(EntityEvent $event) {
        $eventEntity = $event->getEntity();

        // No point in signaling myself
        if ($eventEntity->getId() == $this->entity->getId()) {
            return;
        }

        // Trigger handler
        $this->entity->onEntityCreateEvent($event);
        // Update last signal
        $this->entity->setLastSignalReceived('onEntityCreate', $event);
    }

}