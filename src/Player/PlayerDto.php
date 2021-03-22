<?php

declare(strict_types=1);

namespace App\Player;

use App\Player\MoveStrategy\MoveStrategyInterface;

class PlayerDto
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var MoveStrategyInterface
     */
    private $strategy;

    /**
     * @param string                $name
     * @param MoveStrategyInterface $strategy
     */
    public function __construct(string $name, MoveStrategyInterface $strategy)
    {
        $this->name = $name;
        $this->strategy = $strategy;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return MoveStrategyInterface
     */
    public function getStrategy(): MoveStrategyInterface
    {
        return $this->strategy;
    }
}
