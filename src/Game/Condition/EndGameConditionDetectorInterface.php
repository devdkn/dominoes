<?php

declare(strict_types=1);

namespace App\Game\Condition;

use App\Board\Board;
use App\Player\PlayerInfoInterface;

interface EndGameConditionDetectorInterface
{
    /**
     * @param PlayerInfoInterface $playerInfo
     *
     * @return bool
     */
    public function isWinner(PlayerInfoInterface $playerInfo): bool;

    /**
     * @param Board $board
     *
     * @return bool
     */
    public function isBlocked(Board $board): bool;
}
