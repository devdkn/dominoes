<?php

declare(strict_types=1);

namespace AppTest\unit\Output;

use App\Output\StdoutOutput;
use PHPUnit\Framework\TestCase;

class StdoutOutputTest extends TestCase
{
    public function testWriteln()
    {
        $string = '12312312';

        $this->expectOutputString($string . \PHP_EOL);

        (new StdoutOutput())->writeln($string);
    }
}
