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
use PHPHearthSim\Model\Minion;
use PHPHearthSim\Model\HeroPower;

/**
 * Hero.
 * This class controls the players hero stats, weapons, interactions, hero power etc...
 *
 * @class Hero
 */
abstract class Hero extends Minion {

    /** {@inheritDoc} */
    protected $rarity = Entity::RARITY_UNIQUE;

    /**
     * The amount of armor the hero have
     *
     * @var int
     */
    protected $armor;

    /**
     * The hero power
     * TODO: implement
     *
     * @var \PHPHearthSim\Model\HeroPower;
     */
    protected $heroPower;

    /**
     * Constructor
     * Hero is abstract, but the extended classes should in constructors pass in options for hero power etc
     *
     * @param array $options Options to set during initialization
     */
    public function __construct(array $options = []) {
        // Set hero power reference
        if (isset($options['heroPower']) && $options['heroPower'] instanceof HeroPower) {
            $this->heroPower = $options['heroPower'];
        }

        // Call the parent constructor to set up events, etc.
        parent::__construct($options);
    }

    /**
     * Return hero power
     *
     * @return \PHPHearthSim\Model\HeroPower
     */
    public function getHeroPower() {
        return $this->heroPower;
    }

    /**
     * Use hero power on target
     *
     * @param \PHPHearthSim\Model\Entity $target
     * @return \PHPHearthSim\Model\Hero
     */
    public function useHeroPower(Entity $target = null) {
        // TODO: make sure entity can be targeted (like Faerie Dragon can not be targeted by hero power)
        if ($this->heroPower != null) {
            $this->heroPower->useOn($target);
        }

        return $this;
    }

    /**
     * Get the hero armor
     *
     * @return int The armor value
     */
    public function getArmor() {
        return $this->armor;
    }

    /**
     * Handle gain armor
     *
     * @param int $amount The amount of armor gained
     * @return \PHPHearthSim\Model\Hero The hero
     */
    public function gainArmor($amount = 0) {
        if ($amount > 0) {
            $this->armor += $amount;

            // Emit that we gained armor
            $this->emit(EntityEvent::EVENT_ENTITY_GAIN_ARMOR, ['amount' => $amount]);
        }

        return $this;
    }

    /** {@inheritDoc} */
    public function takeDamage($amount = 0, Entity $from = null) {
        // Just make sure damage is a positive value so we don't get any wierd interactions
        if ($amount < 0) {
            $amount = 0;
        }

        $armor = $this->getArmor();
        $armorAdjustment = 0;

        if ($armor > 0) {
            $armorAdjustment = ($amount > $armor) ? $armor : $amount;

            // Adjust the armor value
            $this->armor -= $armorAdjustment;

            // Emit that we removed armor
            $this->emit(EntityEvent::EVENT_ENTITY_REMOVE_ARMOR, ['amount' => $armorAdjustment]);
        }

        // Update amount to reduce for armor removed
        $amount -= $armorAdjustment;

        // Pass back to base entity handling, any leftover amount is handled here.
        return parent::takeDamage($amount, $from);
    }
}