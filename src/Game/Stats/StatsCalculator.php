<?php

declare(strict_types=1);

namespace App\Game\Stats;

use App\Player\PlayerInfoInterface;
use App\Player\PlayersSet;

class StatsCalculator implements StatsCalculatorInterface
{
    /**
     * @param PlayersSet $players
     *
     * @return Stats
     */
    public function calculateForBlocked(PlayersSet $players): Stats
    {
        $min = null;
        $winner = null;
        $items = [];

        for ($count = 0, $player = $players->current(); $count < $players->count(); ++$count, $player = $players->next()) {
            $sum = $player->getPlayersTiles()->sumValues();
            $items[] = new StatsItem($player, $sum);
            if ($min === null || $sum < $min) {
                $min = $sum;
                $winner = $player;
            }
        }
        if ($winner === null) {
            throw new \LogicException('Cannot determine winner');
        }

        return new Stats($winner, ...$items);
    }

    /**
     * @param PlayerInfoInterface $winner
     * @param PlayersSet          $players
     *
     * @return Stats
     */
    public function calculateForWinner(PlayerInfoInterface $winner, PlayersSet $players)
    {
        $items = [];
        for ($count = 0, $player = $players->current(); $count < $players->count(); ++$count, $player = $players->next()) {
            $sum = $player->getPlayersTiles()->sumValues();
            $items[] = new StatsItem($player, $sum);
        }

        return new Stats($winner, ...$items);
    }
}
