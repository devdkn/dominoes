<?php

declare(strict_types=1);

namespace App\Util;

class NumberGenerator
{
    /**
     * @param int $min
     * @param int $max
     *
     * @return int
     */
    public function randomNumber(int $min, int $max): int
    {
        return \mt_rand($min, $max);
    }
}
