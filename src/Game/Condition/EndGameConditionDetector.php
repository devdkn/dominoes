<?php

declare(strict_types=1);

namespace App\Game\Condition;

use App\Board\Board;
use App\Player\PlayerInfoInterface;

class EndGameConditionDetector implements EndGameConditionDetectorInterface
{
    /**
     * @var int
     */
    private $maxTileValuesOnBoard;

    /**
     * @param int $uniqueValuesPerTileSide
     */
    public function __construct(int $uniqueValuesPerTileSide)
    {
        // unique values per side + 1 (the second side of a "double" tile).
        $this->maxTileValuesOnBoard = $uniqueValuesPerTileSide + 1;
    }

    /**
     * @param PlayerInfoInterface $playerInfo
     *
     * @return bool
     */
    public function isWinner(PlayerInfoInterface $playerInfo): bool
    {
        return $playerInfo->getPlayersTiles()->count() === 0;
    }

    /**
     * @param Board $board
     *
     * @return bool
     */
    public function isBlocked(Board $board): bool
    {
        return $board->getValueCount($board->getRightValue()) === $this->maxTileValuesOnBoard
            && $board->getValueCount($board->getLeftValue()) === $this->maxTileValuesOnBoard;
    }
}
