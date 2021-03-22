<?php

declare(strict_types=1);

namespace AppTest\functional\Game\Stub;

use App\Game\EventHandler\GameEventHandlerInterface;
use App\Game\Stats\Stats;
use App\Move\MoveResult\AddLeftResult;
use App\Move\MoveResult\AddRightResult;
use App\Move\MoveResult\MoveResultInterface;
use App\Move\MoveResult\PickStockResult;
use App\Move\MoveResult\SkipResult;
use App\Player\PlayerInfoInterface;

class GameEventHandlerStub implements GameEventHandlerInterface
{
    public function handleMoveResult(PlayerInfoInterface $player, MoveResultInterface $moveResult): void
    {
        // stub, do nothing
    }

    public function handleGameEndWinner(Stats $stats): void
    {
        // stub, do nothing
    }

    public function handleGameEndBlocked(PlayerInfoInterface $blocker, Stats $stats): void
    {
        // stub, do nothing
    }

    public function visitAddLeftResult(PlayerInfoInterface $player, AddLeftResult $result): void
    {
        // stub, do nothing
    }

    public function visitAddRightResult(PlayerInfoInterface $player, AddRightResult $result): void
    {
        // stub, do nothing
    }

    public function visitPickStockResult(PlayerInfoInterface $player, PickStockResult $result): void
    {
        // stub, do nothing
    }

    public function visitSkipResult(PlayerInfoInterface $player, SkipResult $result): void
    {
        // stub, do nothing
    }
}
