<?php

declare(strict_types=1);

namespace App\Move\MoveResult;

use App\Board\Board;
use App\Player\PlayerInfoInterface;
use App\Tile\Tile;

class AddLeftResult implements MoveResultInterface
{
    /**
     * @var Board
     */
    private $board;

    /**
     * @var Tile
     */
    private $oldLeft;

    /**
     * @param Board $board
     * @param Tile  $oldLeft
     */
    public function __construct(Board $board, Tile $oldLeft)
    {
        $this->board = $board;
        $this->oldLeft = $oldLeft;
    }

    /**
     * {@inheritdoc}
     */
    public function accept(PlayerInfoInterface $player, MoveResultVisitorInterface $visitor): void
    {
        $visitor->visitAddLeftResult($player, $this);
    }

    /**
     * @return Board
     */
    public function getBoard(): Board
    {
        return $this->board;
    }

    /**
     * @return Tile
     */
    public function getOldLeft(): Tile
    {
        return $this->oldLeft;
    }
}
