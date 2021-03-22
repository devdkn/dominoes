<?php

declare(strict_types=1);

namespace App\Game\Stats;

use App\Player\PlayerInfoInterface;
use App\Player\PlayersSet;

interface StatsCalculatorInterface
{
    /**
     * @param PlayersSet $players
     *
     * @return Stats
     */
    public function calculateForBlocked(PlayersSet $players): Stats;

    /**
     * @param PlayerInfoInterface $winner
     * @param PlayersSet          $players
     *
     * @return Stats
     */
    public function calculateForWinner(PlayerInfoInterface $winner, PlayersSet $players);
}
