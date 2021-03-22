<?php

declare(strict_types=1);

namespace App\Tile;

class TileSet implements \Countable
{
    /**
     * @phpstan-var array<string, Tile>
     *
     * @var Tile[]
     */
    private $tiles = [];

    /**
     * @param Tile $tile
     */
    public function add(Tile $tile): void
    {
        $this->tiles[$this->calculateKey($tile)] = $tile;
    }

    /**
     * @return Tile|null
     */
    public function pop(): ?Tile
    {
        return \array_pop($this->tiles);
    }

    /**
     * Removes up to N tiles from this set (if it has that many) and returns them as a new set.
     *
     * @param int $number number of tiles to remove from this set and return as a new tile set.
     *
     * @return TileSet
     */
    public function popN(int $number): TileSet
    {
        $tmp = [];
        for ($i = 0; $i < $number && \count($this->tiles) > 0; ++$i) {
            $tmp[] = \array_pop($this->tiles);
        }
        $res = new TileSet();
        for ($i = \count($tmp) - 1; $i > -1; --$i) {
            $res->add($tmp[$i]);
        }

        return $res;
    }

    /**
     * @return int
     */
    public function sumValues(): int
    {
        $res = 0;
        foreach ($this->tiles as $tile) {
            $res += $tile->getLeft() + $tile->getRight();
        }

        return $res;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return \count($this->tiles);
    }

    /**
     * @param Tile $tile
     */
    public function remove(Tile $tile): void
    {
        unset($this->tiles[$this->calculateKey($tile)]);
    }

    /**
     * @param int $value
     *
     * @return TileSet
     */
    public function filterByValue(int $value): TileSet
    {
        $res = new TileSet();
        foreach ($this->tiles as $tile) {
            if ($tile->getRight() === $value || $tile->getLeft() === $value) {
                $res->add($tile);
            }
        }

        return $res;
    }

    /**
     * @param Tile $tile
     *
     * @return string
     */
    private function calculateKey(Tile $tile): string
    {
        $left = $tile->getLeft();
        $right = $tile->getRight();
        // Make sure that flipped tiles, such as 1:2 and 2:1, are not stored as two separate tiles.
        if ($left < $right) {
            return $left . ':' . $right;
        }
        return $right . ':' . $left;
    }
}
