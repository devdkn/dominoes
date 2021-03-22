<?php

declare(strict_types=1);

namespace App\Board;

use App\Tile\Tile;

class Board
{
    /**
     * @phpstan-var \SplDoublyLinkedList<Tile>
     * @var \SplDoublyLinkedList
     */
    private $tiles;

    /**
     * @var Tile
     */
    private $left;

    /**
     * @var Tile
     */
    private $right;

    /**
     * @phpstan-var array<int, int>
     * @var int[]
     */
    private $valueCounts = [];

    /**
     * @param Tile $initialTile
     */
    public function __construct(Tile $initialTile)
    {
        // \Ds\Dequeue would be a more modern and fast alternative, but just to avoid additional dependency,
        // the \SplDoublyLinkedList is used here.
        $this->tiles = new \SplDoublyLinkedList();
        $this->tiles->push($initialTile);

        $this->left = $initialTile;
        $this->right = $initialTile;
        $this->updateValueCounts($initialTile);
    }

    /**
     * @param Tile $tile
     */
    public function addLeft(Tile $tile): void
    {
        $leftValue = $this->getLeftValue();
        if ($tile->getRight() !== $leftValue) {
            throw new \LogicException(
                'Cannot connect a tile ' . (string) $tile . ' to the left side of the board (' . $leftValue . ')'
            );
        }

        $this->tiles->unshift($tile);
        $this->left = $tile;
        $this->updateValueCounts($tile);
    }

    /**
     * @param Tile $tile
     */
    public function addRight(Tile $tile): void
    {
        $rightValue = $this->getRightValue();
        if ($tile->getLeft() !== $rightValue) {
            throw new \LogicException(
                'Cannot connect a tile ' . (string) $tile . ' to the right side of the board (' . $rightValue . ')'
            );
        }

        $this->tiles->push($tile);
        $this->right = $tile;
        $this->updateValueCounts($tile);
    }

    /**
     * @param int $value
     *
     * @return int
     */
    public function getValueCount(int $value): int
    {
        return $this->valueCounts[$value] ?? 0;
    }

    /**
     * @param Tile $tile
     */
    private function updateValueCounts(Tile $tile): void
    {
        foreach ([$tile->getLeft(), $tile->getRight()] as $val) {
            if (!isset($this->valueCounts[$val])) {
                $this->valueCounts[$val] = 0;
            }
            $this->valueCounts[$val]++;
        }
    }

    /**
     * @return Tile
     */
    public function getLeft(): Tile
    {
        return $this->left;
    }

    /**
     * @return Tile
     */
    public function getRight(): Tile
    {
        return $this->right;
    }

    /**
     * @return int
     */
    public function getLeftValue(): int
    {
        return $this->left->getLeft();
    }

    /**
     * @return int
     */
    public function getRightValue(): int
    {
        return $this->right->getRight();
    }

    /**
     * @phpstan-return \Traversable<int,Tile>
     * @return \Traversable
     */
    public function getTilesIterator(): \Traversable
    {
        return $this->tiles;
    }
}
