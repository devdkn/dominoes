<?php

declare(strict_types=1);

namespace App\Move;

use App\Move\MoveResult\MoveResultInterface;
use App\Move\MoveResult\SkipResult;

class SkipMove implements MoveInterface
{
    /**
     * {@inheritdoc}
     */
    public function advancePlayer(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): MoveResultInterface
    {
        return new SkipResult();
    }
}
