# php-hearthsim
A PHP Hearthstone simulation project

# Introduction
I love three things in life.
* My girlfriend (no brag)
* Developing, analyzing data and AI
* Games

Combining my love for development and games accompanied with AI and analyzation has driven me to start working on this project. I want to keep the code Open Source, so that everybody can benefit and help expand upon the ideas. 

The goal of this project is not to reproduce the game as a full, but rather to help simulate the functionality inside the game. The concepts provided in this project will allow people to create AI, checks, calculations and other neat stuff around the world of Hearthstone (tm).

Hearthstone(tm) is a trademark product from Blizzard Entertainment (tm).

# Installation
After you checkout or fork the project you need to make sure you have composer and then run: 
```sh
$ composer install
```
Please refer to http://getcomposer.org to get the composer component if you do not already have this installed.

This will install the dependencies that the simulator requires to funciton correctly.

Once composer is finished you can run the tests to make sure that it works.

```sh
$ vendor/bin/phpunit
```

You should see something of the following output:

```php
PHPUnit 4.3.5 by Sebastian Bergmann.
Configuration read from /home/marius/hearthstone/php-hearthsim/phpunit.xml
......
Time: 276 ms, Memory: 3.50Mb
OK (6 tests, 16 assertions)
```

This verifies that your system can run the required simulations.

Now you are free to play with the code base and hopefully make something cool! :-)

# TODO / FEATURES

## Game mechanics
- [x] ~~General event handling~~
- [x] ~~End Turn / Start Turn~~
- [x] ~~"The coin" / Cards that give mana ramp / boost~~
- [x] ~~Mana crystals and mana handling~~
- [ ] Minion attacking other minion on battlefield
- [ ] Playing cards from hand to the battlefield
- [ ] Playing spells from hand
- [ ] Draw cards from deck
- [ ] Place destroyed minions on board to graveyard
- [ ] Fatiuge
- [ ] Tribe synergy

### Game altering minions (uncomplete list)
- [x] ~~Auchenai Soulpriest~~
- [ ] Brann Bronzebeard
- [ ] Baron Rivendare

### Minion/spell effects
- [ ] Battlecry
- [x] ~~Deathrattle~~
- [ ] Charge
- [ ] Taunt
- [ ] Divine shield
- [ ] Stealth
- [ ] Enrage
- [ ] Windfury
- [ ] Immune
- [ ] Untargetable
- [ ] Freeze / Frozen
- [ ] Silence
- [ ] Spell damage
- [ ] Return to hand
- [ ] Transform (i.e faceless manipulator)
- [ ] Auras (like Dire Wolf Alpha)
- [ ] Temporary buffs or debuffs that only last this turn (Abusive Seargant)
- [x] ~~Temporary mana~~
- [ ] Discover 

### Card effects
- [ ] Choose One (Druid)
- [ ] Combo (Rogue)
- [ ] Overload (Shaman)

### Heroes
- [ ] Druid
  - [ ] Malfurion Stormrage
- [ ] Hunter
  - [ ] Rexxar
  - [ ] Alleria Windrunner
- [ ] Mage
  - [ ] Jaina Proudmoore
  - [ ] Medivh
- [ ]  Paladin
  - [ ] Uther Lightbringer
- [x] ~~Priest~~
  - [x] ~~Auduin Wrynn~~
- [ ] Rogue
  - [ ] Valeera Sanguinar
- [x] ~~Shaman~~
  - [x] ~~Thrall~~
- [ ] Warrior
  - [x] ~~Grommash Hellscream~~
  - [ ] Magni Bronzebeard

### Hero Powers
- [x] ~~General hero power support~~
- [ ] Druid: Shapeshift
- [ ] Hunter: Steadyshot
- [ ] Mage: Fireblast
- [ ] Paladin: Reinforce
- [x] ~~Priest: Lesser Heal~~
- [ ] Rogue: Dagger Mastery
- [x] ~~Shaman: Totemic Call~~
- [ ] Warlock: Life Tap
- [x] ~~Warrior: Armor Up!~~

### Weapons
- [ ] General weapon support

### Secrets
- [ ] General secret support

### Limitations
- [ ] Deck limitations (maximum/minimum of 30 cards in deck at start)
- [x] ~~Maximum mana without the possibility to go over 10 available total mana~~
- [x] ~~Minions on board (maximum of 7 per side)~~
- [ ] Cards on hand (maximum of 10 cards per hand)














