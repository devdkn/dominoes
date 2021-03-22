<?php

declare(strict_types=1);

namespace App\Player;

class PlayersSet implements \Countable
{
    /**
     * @var Player[]
     */
    private $players;

    /**
     * @var int
     */
    private $num;

    /**
     * @var int
     */
    private $activeIndex = 0;

    /**
     * @param Player $firstPlayer
     * @param Player $secondPlayer
     * @param Player ...$otherPlayers
     */
    public function __construct(Player $firstPlayer, Player $secondPlayer, Player ...$otherPlayers)
    {
        $this->players = \array_merge([$firstPlayer, $secondPlayer], $otherPlayers);
        $this->num = \count($this->players);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->num;
    }

    /**
     * @return Player
     */
    public function current(): Player
    {
        return $this->players[$this->activeIndex];
    }

    /**
     * @return Player
     */
    public function next(): Player
    {
        if (!isset($this->players[++$this->activeIndex])) {
            $this->activeIndex = 0;
        }

        return $this->players[$this->activeIndex];
    }
}
