<?php

declare(strict_types=1);

namespace App\Player;

use App\Player\MoveStrategy\MoveStrategyInterface;
use App\Tile\TileSet;

class PlayerSetFactory
{
    /**
     * @param TileSet $stock
     * @param int     $tilesPerPlayer
     * @param PlayerDto  $player1
     * @param PlayerDto  $player2
     * @param PlayerDto  ...$otherPlayers
     *
     * @return PlayersSet
     */
    public function createPlayersSet(
        TileSet $stock,
        int $tilesPerPlayer,
        PlayerDto $player1,
        PlayerDto $player2,
        PlayerDto ...$otherPlayers
    ): PlayersSet {
        $players = [
            $this->createPlayer($player1, $tilesPerPlayer, $stock),
            $this->createPlayer($player2, $tilesPerPlayer, $stock),
        ];
        foreach ($otherPlayers as $otherPlayer) {
            $players[] = $this->createPlayer($otherPlayer, $tilesPerPlayer, $stock);
        }

        return new PlayersSet(...$players);
    }

    /**
     * @param PlayerDto $dto
     * @param int       $numberOfTiles
     * @param TileSet   $stock
     *
     * @return Player
     */
    private function createPlayer(PlayerDto $dto, int $numberOfTiles, TileSet $stock): Player
    {
        $playerSet = $stock->popN($numberOfTiles);
        if (\count($playerSet) !== $numberOfTiles) {
            throw new \LogicException(
                'Failed to pull ' . $numberOfTiles . ' tiles from the stock for the player ' . $dto->getName() . '.'
            );
        }

        return new Player($dto->getName(), $playerSet, $dto->getStrategy());
    }

    /**
     * @param string                $name
     * @param MoveStrategyInterface $strategy
     *
     * @return PlayerDto
     */
    public function createDto(string $name, MoveStrategyInterface $strategy): PlayerDto
    {
        return new PlayerDto($name, $strategy);
    }
}
