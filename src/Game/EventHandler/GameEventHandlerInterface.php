<?php

declare(strict_types=1);

namespace App\Game\EventHandler;

use App\Game\Stats\Stats;
use App\Move\MoveResult\MoveResultInterface;
use App\Move\MoveResult\MoveResultVisitorInterface;
use App\Player\PlayerInfoInterface;

interface GameEventHandlerInterface extends MoveResultVisitorInterface
{
    /**
     * @param PlayerInfoInterface $player
     * @param MoveResultInterface $moveResult
     */
    public function handleMoveResult(PlayerInfoInterface $player, MoveResultInterface $moveResult): void;

    /**
     * @param Stats $stats
     */
    public function handleGameEndWinner(Stats $stats): void;

    /**
     * @param PlayerInfoInterface $blocker
     * @param Stats               $stats
     */
    public function handleGameEndBlocked(PlayerInfoInterface $blocker, Stats $stats): void;
}
