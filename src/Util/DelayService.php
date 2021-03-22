<?php

declare(strict_types=1);

namespace App\Util;

class DelayService
{
    /**
     * @param int $seconds
     */
    public function sleep(int $seconds): void
    {
        \sleep($seconds);
    }
}
