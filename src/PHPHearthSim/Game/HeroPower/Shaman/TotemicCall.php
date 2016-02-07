<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015-2016 Switchback
 * @date: 04 02 2016
 */
namespace PHPHearthSim\Game\HeroPower\Shaman;

use PHPHearthSim\Model\EntityClass\Shaman;
use PHPHearthSim\Model\Entity;
use PHPHearthSim\Model\HeroPower;
use PHPHearthSim\Game\Token\H\HealingTotem;
use PHPHearthSim\Game\Token\S\SearingTotem;
use PHPHearthSim\Game\Token\S\StoneclawTotem;
use PHPHearthSim\Game\Token\W\WrathOfAirTotem;

/**
 * Totemic Call
 * Summon a random totem
 *
 * @class TotemicCall
 */
class TotemicCall extends HeroPower implements Shaman {

    /** {@inheritDoc} */
    protected $name = 'Totemic Call';

    /**
     * Hero power:
     * Summon a random totem
     *
     * @param \PHPHearthSim\Model\Entity $target
     * @return \PHPHearthSim\Game\HeroPower\Shaman\TotemicCall
     * */
    public function useOn(Entity $target = null) {
        // Call parent to update usage, etc
        parent::useOn($target);

        // Create a random totem that does not already exist
        $randomTotem = $this->createRandomTotemNotOnBattlefield();

        // Make sure we have a random totem
        if ($randomTotem != null) {
            // Add totem to battlefield
            $this->getOwner()->addToBattlefield($randomTotem);
        }

        return $this;
    }

    /**
     * Method to create a random totem that does not already exist on the battlefield for player
     *
     * @return \PHPHearhSim\Model\Entity|null return a random totem or null
     */
    public function createRandomTotemNotOnBattlefield() {
        // Creatable tokens
        $createable = [
            new HealingTotem(),
            new SearingTotem(),
            new StoneclawTotem(),
            new WrathOfAirTotem()
        ];

        // Get board
        $board = $this->getOwner()->getBoard();

        // Loop over createable minions
        foreach ($createable as $i => $entity) {
            // If minion type is on battlefield it we should not create it again
            if ($board->isOnBattlefield(get_class($entity), $this->getOwner())) {
                unset($createable[$i]);
            }
        }

        // Return a random createable minion or null
        return (!empty($createable)) ? array_values($createable)[rand(0, count($createable)-1)] : null;
    }
}