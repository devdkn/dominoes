<?php

declare(strict_types=1);

namespace App\Output;

class StdoutOutput implements OutputInterface
{
    /**
     * @param string $string
     */
    public function writeln(string $string): void
    {
        echo $string, \PHP_EOL;
    }
}
