<?php

/**
 * PHPHearthSim - A Hearthstone simulator written in PHP
 *
 * @author:     Switchback <switchback@exchange.no>
 * @copyright   Copyright (C) 2015 Switchback
 * @date: 13 12 2015
 */
namespace PHPHearthSim\Model;

use PHPHearthSim\Model\Player;
use PHPHearthSim\Event\EntityEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class to hold and control the game board
 *
 * Responsible for:
 * - Board minions and adjustments
 * - Heroes
 * - Unit attacks
 * - Playing card (entities) from "hand"
 * - Draw cards (from deck)
 *
 *
 * @class Board
 * @property-read int $entityCounter get the entity count
 * @property int $turn set/get the current turn number
 * @property \PHPHearthSim\Model\Player $me set/get my player
 * @property \PHPHearthSim\Model\Player $opponent set/get opponent player
 * @property \PHPHearthSim\Model\Player $activePlayer set/get active player
 * @property \Symfony\Component\EventDispatcher\EventDispatcher $dispatcher set/get the event dispatcher
 */
class Board {

    /**
     * The entity counter
     *
     * @var int
     */
    private $entityCounter = 0;

    /**
     * Current turn number
     *
     * @var int
     */
    protected $turn;

    /**
     * My player
     *
     * @var \PHPHearthSim\Model\Player
     */
    protected $me;

    /**
     * Opponent player
     *
     * @var \PHPHearthSim\Model\Player
     * */
    protected $opponent;

    /**
     * Active player
     *
     * @var \PHPHearthSim\Model\Player
     * */
    protected $activePlayer;

    /**
     * Event dispatcher
     *
     * @var \Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected $dispatcher;

    /**
     * Construct new board
     *
     * @param \PHPHearthSim\Model\Player $me
     * @param \PHPHearthSim\Model\Player $opponent
     */
    public function __construct(Player $me, Player $opponent) {
        // Reset entity counter
        $this->entityCounter = 0;
        // Create event dispatcher
        $this->dispatcher = new EventDispatcher();

        // Set the players
        $this->setMe($me);
        $this->setOpponent($opponent);

        // Initialize the turn
        $this->setTurn(1);

        // Toss a coin
        $coin = rand(0, 1);

        // Set active player based on coin result
        $activePlayer = ($coin == 0) ? $me : $opponent;
        $this->setActivePlayer($activePlayer);
    }

    /**
     * Set the event dispatcher
     *
     * @param \Symfony\Component\EventDispatcher\EventDispatcher $dispatcher
     *
     * @return \PHPHearthSim\Model\Board
     */
    public function setDispatcher(EventDispatcher $dispatcher) {
        $this->dispatcher = $dispatcher;

        return $this;
    }

    /**
     * Get the event dispatcher
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    public function getDispatcher() {
        return $this->dispatcher;
    }

    /**
     * Subscribe to events
     *
     * @param unknown $subscriber
     * @return \PHPHearthSim\Model\Board
     */
    public function subscribe($subscriber) {
        $this->getDispatcher()->addSubscriber($subscriber);

        return $this;
    }

    /**
     * Emit an event to the rest of the game
     *
     * @param string $eventName
     * @param \PHPHearthSim\Event\EntityEvent $event
     * @return \PHPHearthSim\Game\Board
     */
    public function emit($eventName, EntityEvent $event) {
        $this->getDispatcher()->dispatch($eventName, $event);

        return $this;
    }

    /**
     * Set the turn number
     *
     * @param int $turn
     * @return \PHPHearthSim\Game\Board
     */
    public function setTurn($turn) {
        $this->turn = $turn;

        return $this;
    }

    /**
     * Get the turn number
     *
     * @return int
     */
    public function getTurn() {
        return $this->turn;
    }

    /**
     * Set my player
     *
     * @param \PHPHearthSim\Model\Player $me
     * @return \PHPHearthSim\Game\Board
     */
    public function setMe(Player $me) {
        // Set board reference
        $me->setBoard($this);

        $this->me = $me;

        return $this;
    }

    /**
     * Return my player
     *
     * @return \PHPHearthSim\Model\Player
     */
    public function getMe() {
        return $this->me;
    }

    /**
     * Set opponent player
     *
     * @param \PHPHearthSim\Model\Player $opponent
     * @return \PHPHearthSim\Game\Board
     */
    public function setOpponent(Player $opponent) {
       // Set board reference
       $opponent->setBoard($this);

       $this->opponent = $opponent;

       return $this;
    }

    /**
     * Return opponent player
     *
     * @return \PHPHearthSim\Model\Player
     */
    public function getOpponent() {
        return $this->opponent;
    }

    /**
     * Set the active player
     *
     * @param \PHPHearthSim\Model\Player $activePlayer
     * @return \PHPHearthSim\Model\Board
     */
    public function setActivePlayer(Player $activePlayer) {
        $this->activePlayer = $activePlayer;

        return $this;
    }

    /**
     * Get the active player
     *
     * @return \PHPHearthSim\Model\Player
     */
    public function getActivePlayer() {
        return $this->activePlayer;
    }

    /**
     * Return a unique entity identifier based on entityCounter
     *
     * @return string
     */
    public function generateEntityId() {
        $this->entityCounter++;
        return 'ENT_' . str_pad($this->entityCounter, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Method to handle end turn logic
     *
     * @return \PHPHearthSim\Model\Board
     */
    public function endTurn() {
        // Increment turn counter
        $this->turn++;
        // Call end turn for current active player
        $this->getActivePlayer()->endTurn();
        // Toggle active player and trigger start turn for new active player
        $this->toggleActivePlayer()->getActivePlayer()->startTurn();

        return $this;
    }

    /**
     * Helper function to toggle active player based on current active player
     *
     * @return \PHPHearthSim\Model\Board
     */
    private function toggleActivePlayer() {
        $newActivePlayer = ($this->getActivePlayer()->getId() == $this->getMe()->getId()) ? $this->getOpponent() : $this->getMe();
        $this->setActivePlayer($newActivePlayer);

        return $this;
    }
}