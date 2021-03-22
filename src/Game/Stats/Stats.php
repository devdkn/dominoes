<?php

declare(strict_types=1);

namespace App\Game\Stats;

use App\Player\PlayerInfoInterface;

class Stats
{
    /**
     * @var PlayerInfoInterface
     */
    private $winner;

    /**
     * @var StatsItem[]
     */
    private $items;

    /**
     * @param PlayerInfoInterface $winner
     * @param StatsItem           ...$items
     */
    public function __construct(PlayerInfoInterface $winner, StatsItem ...$items)
    {
        $this->winner = $winner;
        $this->items = $items;
    }

    /**
     * @return PlayerInfoInterface
     */
    public function getWinner(): PlayerInfoInterface
    {
        return $this->winner;
    }

    /**
     * @return StatsItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
