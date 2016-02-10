<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 18 12 2015
 */
namespace PHPHearthSim\Model;

use PHPHearthSim\Model\Entity;
use PHPHearthSim\Event\EntityEvent;
use PHPHearthSim\Model\Mechanic\Deathrattle;

/**
 * Minion.
 * Extends the Entity class. Adds functionality that only applies to Minions and Heroes
 *
 * @class Minion
 * @property-read int $baseHealth get entity base health
 * @property-read int $baseAttack get entity base attack
 */
abstract class Minion extends Entity {

    /**
     * The base health of a entity (before reduction or penalties from other adjustments)
     *
     * @var int
     */
    protected $baseHealth;

    /**
     * The base attack of a entity (before reduction or penalties from other adjustments)
     * @var int
     */
    protected $baseAttack;

    /**
     * If unit has been silenced.
     * You can never remove a silence.
     *
     * @var boolean
     */
    protected $silenced = false;


    /**
     * List of deathrattle effects to run when minion dies
     *
     * @var array
     */
    protected $deathrattle = [];

    /**
     * Constructor
     * Allow to set some options like adjustments on initialization
     *
     * @param array $options Options to set during initialization
     */
    public function __construct(array $options = []) {
        // Add deathrattle effects
        if (isset($options['deathrattle'])) {
            foreach ($options['deathrattle'] as $deathrattle) {
                if ($deathrattle instanceof Deathrattle) {
                    $this->deathrattle[] = $deathrattle;
                }
            }
        }

        // Pass to Entity::__construct
        parent::__construct($options);
    }

    /**
     * Get the entity base health
     *
     * @return int
     */
    public function getBaseHealth() {
        return $this->baseHealth;
    }

    /**
     * Get the entity base attack
     *
     * @return int
     */
    public function getBaseAttack() {
        return $this->baseAttack;
    }

    /**
     * Get the current entity health
     *
     * @return int
     */
    public function getHealth() {
        $health = $baseHealth = $this->baseHealth;

        foreach ($this->getAdjustments() as $adjustment) {
            // check for health adjustments
            switch ($adjustment->getType()) {
                // Adjust the health, add or subtract value
                case EntityAdjustment::ADJUSTMENT_HEALTH:
                    $health += $adjustment->getValue();

                    // Make sure health is never higher than maximum health
                    if ($health > $baseHealth) {
                        $health = $baseHealth;
                    }

                    break;

                    // Force new health value
                case EntityAdjustment::SET_HEALTH:
                    $health = $adjustment->getValue();
                    break;

                    // TODO: Figure out what we do about "auras", like wolf that gives +1 attack to adjecent minions.
                    // Option 1) Use a AURA_ATTACK / AURA_HEALTH type and process them at the end
                    // Option 2) Use a different mechanic, not adjustments
            }
        }

        return $health;
    }

    /**
     * Get the current entity attack
     *
     * @return int
     */
    public function getAttack() {
        return 0;
    }

    /**
     * Function to return if unit has been silenced or not
     *
     * @return boolean
     */
    public function isSilenced() {
        return $this->silenced;
    }

    /**
     * When the entity is destroyed
     *
     * @return \PHPHearthSim\Model\Entity;
     */
    public function destroy() {
        if ($this->isDeathrattle()) {

            foreach ($this->deathrattle as $deathrattle) {
                // TODO: see if it matters what order the emit and $deathrattle->execute() is called.
                $this->emit(EntityEvent::EVENT_ENTITY_DEATHRATTLE);
                $deathrattle->execute($this);
            }

        }

        return $this;
    }

    /**
     * Silence the entity, removing current buffs and deathrattle effects
     *
     * @return \PHPHearthSim\Model\Entity
     */
    public function silence() {
        // Set silenced flag
        $this->silenced = true;
        // Clear applied deathrattles
        $this->deathrattle = [];

        // TODO: Loop and remove buffs or debuffs.

        return $this;
    }

    /**
     * Check if minion has deathrattle effect
     *
     * @return boolean
     */
    public function isDeathrattle() {
        return count($this->deathrattle) > 0;
    }

    /**
     * Check if a spcific deathrattle is included in minions deathrattle list
     *
     * @param Deathrattle $deathrattle The deathrattle effect to check for
     * @return boolean
     */
    public function hasDeathrattle(Deathrattle $deathrattle) {
        // Make sure minion has deathrattle effect active
        if ($this->isDeathrattle()) {
            // Loop over deathrattle effects
            foreach ($this->deathrattle as $myDeathrattle) {
                // See if deathrattle effect matches requested deathrattle
                if (is_a($myDeathrattle, get_class($deathrattle))) {
                    return true;
                }
            }
        }

        // No matches found
        return false;
    }

    /**
     * Get a deathrattle by index
     *
     * @param number $index
     * @return Deathrattle|null
     */
    public function getDeathrattleByIndex($index = 0) {
        return (isset($this->deathrattle[$index])) ? $this->deathrattle[$index] : null;
    }

    /**
     * When the entity takes damage
     *
     * @param number $amount The amount of damage taken
     * @param \PHPHearthSim\Model\Entity $from The entity that did damage to us
     * @return \PHPHearthSim\Model\Entity
     */
    public function takeDamage($amount = 0, Entity $from = null) {
        // Just make sure damage is a positive value so we don't get any wierd interactions
        if ($amount < 0) {
            $amount = 0;
        }

        // Make sure damage is taken
        if ($amount > 0) {
            // Apply adjustment to health
            $this->addAdjustment(new EntityAdjustment(EntityAdjustment::ADJUSTMENT_HEALTH, -$amount));

            // Emit that we took damage
            $this->emit(EntityEvent::EVENT_ENTITY_TAKE_DAMAGE, ['amount' => $amount]);
        }

        return $this;
    }

    /**
     * Trigger healing on entity
     *
     * @param number $amount The amount of healing received
     * @param \PHPHearthSim\Model\Entity $from The entity that did the healing to us
     * @return \PHPHearthSim\Model\Entity
     */
    public function healFor($amount = 0, Entity $from = null) {
        // Just make sure damage is a positive value so we don't get any wierd interactions
        if ($amount < 0) {
            $amount = 0;
        }

        // Check and adjust values
        if ($from != null) {
            // Professor Velen doubles the healing received
            if ($this->getBoard()->isOnBattlefield('PHPHearthSim\Game\Minion\P\ProfessorVelen', $from->getOwner())) {
                $amount = $amount * 2;
            }

            // Auchenai Soulpriest turns healing into damage
            if ($this->getBoard()->isOnBattlefield('PHPHearthSim\Game\Minion\A\AuchenaiSoulpriest', $from->getOwner())) {
                return $this->takeDamage($amount, $from);
            }
        }

        // Apply adjustment to health
        $this->addAdjustment(new EntityAdjustment(EntityAdjustment::ADJUSTMENT_HEALTH, $amount));

        // Emit that we received healing
        $this->emit(EntityEvent::EVENT_ENTITY_RECEIVE_HEAL, ['amount' => $amount]);

        return $this;
    }

    /**
     * temporary
     * TODO: implement or remove enterBattlefield
     */
    public function enterBattlefield() {

    }

    /**
     * temporary
     * TODO: implement or remove exitBattlefield
     */
    public function exitBattlefield() {

    }

    /**
     * Called for each minion that is on the battlefield
     * Useful for entities that alter game behavior, like Auchenai Soulpriest or Brann Bronzebeard
     *
     * @return \PHPHearthSim\Model\Entity;
     */
    public function onBattlefield() {
        return $this;
    }

}