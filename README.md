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