<?php

declare(strict_types=1);

namespace App\Player\MoveStrategy\Ai;

use App\Board\Board;
use App\Tile\Tile;
use App\Tile\TileSet;

class MoveTilePicker
{
    /**
     * @param Board   $board
     * @param TileSet $collection
     *
     * @return Tile|null
     */
    public function pickTileForLeftMove(Board $board, TileSet $collection): ?Tile
    {
        $tileCandidates = $this->calculatePossibleLeftMoves($board, $collection);
        if (\count($tileCandidates) < 1) {
            return null;
        }
        // possibly a more complex logic
        $tile = $tileCandidates->pop();
        if ($tile === null) {
            throw new \LogicException('Unexpected null from a not empty tile set.');
        }

        if ($tile->getRight() === $board->getLeftValue()) {
            return $tile;
        }

        return $tile->flip();
    }

    /**
     * @param Board   $board
     * @param TileSet $collection
     *
     * @return TileSet
     */
    private function calculatePossibleLeftMoves(Board $board, TileSet $collection): TileSet
    {
        return $collection->filterByValue($board->getLeftValue());
    }

    /**
     * @param Board   $board
     * @param TileSet $collection
     *
     * @return Tile|null
     */
    public function pickTileForRightMove(Board $board, TileSet $collection): ?Tile
    {
        $tileCandidates = $this->calculatePossibleRightMoves($board, $collection);
        if (\count($tileCandidates) < 1) {
            return null;
        }
        // possibly a more complex logic
        $tile = $tileCandidates->pop();
        if ($tile === null) {
            throw new \LogicException('Unexpected null from a not empty tile set.');
        }

        if ($tile->getLeft() === $board->getRightValue()) {
            return $tile;
        }

        return $tile->flip();
    }

    /**
     * @param Board   $board
     * @param TileSet $collection
     *
     * @return TileSet
     */
    public function calculatePossibleRightMoves(Board $board, TileSet $collection): TileSet
    {
        return $collection->filterByValue($board->getRightValue());
    }
}
