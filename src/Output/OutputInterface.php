<?php

declare(strict_types=1);

namespace App\Output;

interface OutputInterface
{
    /**
     * @param string $string
     */
    public function writeln(string $string): void;
}
