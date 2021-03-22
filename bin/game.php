<?php

declare(strict_types=1);

include __DIR__ . '/../vendor/autoload.php';

if (isset($_SERVER['argv'][1])) {
    $delay = \filter_var($_SERVER['argv'][1], \FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
    if ($delay === false) {
        echo 'Expected delay to be a positive number', \PHP_EOL;
        exit(1);
    }
} else {
    $delay = 0;
}

$gameFactory = new \App\GameFactory(
    new \App\TileProvider\ShuffleProvider(new \App\TileProvider\GeneratorProvider()),
    new \App\Player\PlayerSetFactory(),
    new \App\Board\Initializer\BoardInitializerFactory(),
    new \App\Player\MoveStrategy\MoveStrategyFactory(),
    new \App\Game\Stats\StatsCalculatorFactory(),
    new \App\Game\Condition\GameConditionFactory()
);
$logEventHandler = new \App\EventHandler\OutputLogHandler(new \App\Output\StdoutOutput(), new \App\EventHandler\Output\Formatter());

$game = $gameFactory->createClassicAiGame($logEventHandler, 'Alice', 'Bob');
$game->start()->run(new \App\Game\Hook\BetweenMovesDelayHook(new \App\Util\DelayService(), $delay));

