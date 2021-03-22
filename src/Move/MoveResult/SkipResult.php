<?php

declare(strict_types=1);

namespace App\Move\MoveResult;

use App\Player\PlayerInfoInterface;

class SkipResult implements MoveResultInterface
{
    public function accept(PlayerInfoInterface $player, MoveResultVisitorInterface $visitor): void
    {
        $visitor->visitSkipResult($player, $this);
    }
}
