<?php

declare(strict_types=1);

namespace App\Tile;

class Tile
{
    /**
     * @var int
     */
    private $left;

    /**
     * @var int
     */
    private $right;

    /**
     * @param int $left
     * @param int $right
     */
    public function __construct(int $left, int $right)
    {
        $this->left = $left;
        $this->right = $right;
    }

    /**
     * @return int
     */
    public function getLeft(): int
    {
        return $this->left;
    }

    /**
     * @return int
     */
    public function getRight(): int
    {
        return $this->right;
    }

    /**
     * @return static
     */
    public function flip(): self
    {
        $new = clone $this;
        $new->left = $this->right;
        $new->right = $this->left;

        return $new;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->left . ':' . $this->right;
    }
}
