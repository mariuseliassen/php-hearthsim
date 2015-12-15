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
use PHPHearthSim\Event\Entity\EntityCreateEvent;
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
        $events[EntityEvent::EVENT_ENTITY_CREATE] = ['handleEvent', 0];

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
     * Handle incoming event
     * 
     * @param EntityEvent $event
     */
    public function handleEvent(EntityEvent $event) {
        $eventEntity = $event->getEntity();
        $eventName = $event->getEventName();
        
        // Make sure entity is listening to the event
        if (!$this->entity->listenTo($eventName)) {
            return;
        }
        
        // Entity create should not signal itself
        if ($eventEntity->getId() == $this->entity->getId()) {
            return;
        }
        
        // See what event it is and call correct handler
        switch($eventName) {
            case EntityEvent::EVENT_ENTITY_CREATE:
                $this->entity->onEntityCreateEvent($event);
                break;
        }
        
        // Update last signal received
        $this->entity->setLastSignalReceived($eventName, $event);
    }

}