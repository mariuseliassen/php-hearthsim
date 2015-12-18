<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
namespace PHPHearthSim\Tests;

use PHPHearthSim\Model\Board;
use PHPHearthSim\Model\Player;
use PHPHearthSim\Game\Card\Z\ZombieChow;
use PHPHearthSim\Event\EntityEvent;
use PHPHearthSim\Event\TestEvent;

class EventTest extends TestCase
{

    /**
     * Test to send invalid signal
     */
    public function testInvalidEntityEventException()
    {
        $this->setExpectedException('PHPHearthSim\Exception\InvalidEntityEventException');
        // First entity should not notify anything
        $entity = new ZombieChow(['board' => $this->board]);

        $entity->emit('InvalidEvent');
    }

    /**
     * Test the sending of EVENT_ENTITY_CREATE signal between entities
     */
    public function testEntityCreateEvent()
    {
        // First entity should not notify anything
        $entity0001 = new ZombieChow(['board' => $this->board]);
        // Second entity should notify the first entity
        $entity0002 = new ZombieChow(['board' => $this->board]);

        // Make sure that first entity has received signal on the second entity creation
        $this->assertEquals($entity0001->getLastSignalReceived()['signal'], EntityEvent::EVENT_ENTITY_CREATE);
        $this->assertEquals($entity0001->getLastSignalReceived()['event']->getEntity()->getId(), $entity0002->getId());

        // Second entity should not have received any notifications
        $this->assertNull($entity0002->getLastSignalReceived()['signal']);

    }

}
