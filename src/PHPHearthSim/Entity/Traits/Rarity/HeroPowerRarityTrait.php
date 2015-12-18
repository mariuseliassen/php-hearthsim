<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
namespace PHPHearthSim\Entity\Traits\Rarity;

/**
 * Trait for card rarity: HeroPower
 * This is a custom case to avoid exception on heropower entities
 *
 * @trait HeroPowerRarityTrait
 */
trait HeroPowerRarityTrait {

    /**
     * Get the trait rarity
     *
     * @return string
     */
    protected function getRarityFromTrait() {
        return 'HeroPower';
    }

}