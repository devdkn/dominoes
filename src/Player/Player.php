<?php

declare(strict_types=1);

namespace App\Player;

use App\Board\Board;
use App\Move\MoveInterface;
use App\Player\MoveStrategy\MoveStrategyInterface;
use App\Tile\TileSet;

class Player implements PlayerInfoInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var TileSet
     */
    private $playersTiles;

    /**
     * @var MoveStrategyInterface
     */
    private $moveStrategy;

    /**
     * @param string                $name
     * @param TileSet               $playersTiles
     * @param MoveStrategyInterface $moveStrategy
     */
    public function __construct(string $name, TileSet $playersTiles, MoveStrategyInterface $moveStrategy)
    {
        $this->name = $name;
        $this->playersTiles = $playersTiles;
        $this->moveStrategy = $moveStrategy;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return TileSet
     */
    public function getPlayersTiles(): TileSet
    {
        return $this->playersTiles;
    }

    /**
     * @param Board   $board
     * @param TileSet $stock
     *
     * @return MoveInterface
     */
    public function createMove(Board $board, TileSet $stock): MoveInterface
    {
        return $this->moveStrategy->createMove($board, $this->playersTiles, $stock);
    }
}
