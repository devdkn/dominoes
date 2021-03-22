<?php

declare(strict_types=1);

namespace App\Move\MoveResult;

use App\Board\Board;
use App\Player\PlayerInfoInterface;
use App\Tile\Tile;

class AddRightResult implements MoveResultInterface
{
    /**
     * @var Board
     */
    private $board;

    /**
     * @var Tile
     */
    private $oldRight;

    /**
     * @param Board $board
     * @param Tile  $oldRight
     */
    public function __construct(Board $board, Tile $oldRight)
    {
        $this->board = $board;
        $this->oldRight = $oldRight;
    }

    /**
     * {@inheritdoc}
     */
    public function accept(PlayerInfoInterface $player, MoveResultVisitorInterface $visitor): void
    {
        $visitor->visitAddRightResult($player, $this);
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
    public function getOldRight(): Tile
    {
        return $this->oldRight;
    }
}
