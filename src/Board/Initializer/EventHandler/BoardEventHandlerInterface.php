<?php

declare(strict_types=1);

namespace App\Board\Initializer\EventHandler;

use App\Board\Board;
use App\Player\PlayerInfoInterface;

interface BoardEventHandlerInterface
{
    /**
     * @param Board               $board
     * @param PlayerInfoInterface $player
     */
    public function onBoardInitializedByPlayer(Board $board, PlayerInfoInterface $player): void;

    /**
     * @param Board $board
     */
    public function onBoardInitializedFromStock(Board $board): void;
}
