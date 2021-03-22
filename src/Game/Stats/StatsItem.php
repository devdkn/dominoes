<?php

declare(strict_types=1);

namespace App\Game\Stats;

use App\Player\PlayerInfoInterface;

class StatsItem
{
    /**
     * @var PlayerInfoInterface
     */
    private $playerInfo;

    /**
     * @var int
     */
    private $sum;

    /**
     * @param PlayerInfoInterface $playerInfo
     * @param int                 $sum
     */
    public function __construct(PlayerInfoInterface $playerInfo, int $sum)
    {
        $this->playerInfo = $playerInfo;
        $this->sum = $sum;
    }

    /**
     * @return PlayerInfoInterface
     */
    public function getPlayerInfo(): PlayerInfoInterface
    {
        return $this->playerInfo;
    }

    /**
     * @return int
     */
    public function getSum(): int
    {
        return $this->sum;
    }
}
