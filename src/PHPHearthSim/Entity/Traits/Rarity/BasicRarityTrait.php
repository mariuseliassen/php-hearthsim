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
 * Trait for card rarity: Basic
 *
 * @trait BasicRarityTrait
 */
trait BasicRarityTrait {

    /**
     * Get the trait rarity
     *
     * @return string
     */
    protected function getRarityFromTrait() {
        return 'Basic';
    }

}