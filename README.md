# Dominoes

A classic 28-tile Dominoes game implementation.
Rules:
* The 28 tiles are shuffled face down and form the stock. Each player draws seven tiles.
* A random player places a random tile to start the line of play.
* The players alternately extend the line of play with one tile at one of its two ends.
* A tile may only be placed next to another tile, if their respective values on the connecting ends are identical.
* If a player is unable to place a valid tile, they must keep on pulling tiles from the stock until they can.
* If there are no tiles in the stock, the player skips their turn.
* The game ends when one of the following conditions is met:
   - A player wins by playing their last tile.
   - There are no possible moves, and the game is considered blocked. In such a case, the winner is the player with the least amount of points (the sum of all tile dots across all player's tiles).

Currently, only AI vs AI (2 players) with CLI output mode is implemented, but the implementation can easily be extended to allow for
* other tile set sizes
* more players
* human interaction 
* various types of output and input

This implementation intentionally does not use any frameworks or libraries, except the composer's autoload file, so some infrastructure code had to be written. Although a DI container would simplify things a bit.

## Requirements

1. PHP 7.3
2. Composer
3. xdebug (optional, to view test coverage report)

This implementation requires PHP version 7.3 via composer.json, as it's the lowest supported PHP version as of [now](https://www.php.net/supported-versions.php).

All other steps below assume that the current working directory is the root directory of this project.

## Installation

Although there are no dependencies in the "require" section of the composer.json, this implementation uses its autoload file. 

1. Install composer dependencies (incl. dev, for tests and quality tools).

`composer install`

## Usage

`php bin/game.php [delay between moves in seconds, integer]`

If php is not available in the current environment, but docker is, a command like the following can be used to run the game

`docker run --rm -v $(pwd):/var/www/ php:7.3.27-cli-alpine3.12 php /var/www/bin/game.php [delay]`

## Quality tools

### Tests

`./vendor/bin/phpunit`

### Test coverage report

`php -dxdebug.mode=coverage ./vendor/bin/phpunit --coverage-text`

If xdebug is not available in the current environment, but docker is, a command like the following can be used to view the coverage report.

`docker run --rm -v $(pwd):/var/www/ mileschou/xdebug:7.3 sh -c 'cd /var/www && php -dxdebug.mode=coverage ./vendor/bin/phpunit --coverage-text'`

### PHPStan report

`./vendor/bin/phpstan analyse`

### PHP CS report

`./vendor/bin/php-cs-fixer fix --dry-run`
