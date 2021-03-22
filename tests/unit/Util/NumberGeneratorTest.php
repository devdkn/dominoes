<?php

declare(strict_types=1);

namespace AppTest\unit\Util;

use App\Util\NumberGenerator;
use PHPUnit\Framework\TestCase;

class NumberGeneratorTest extends TestCase
{
    public function testRandomNumber(): void
    {
        $numberGenerator = new NumberGenerator();
        $expectedList = [0,1,2];
        for ($i = 0; $i < 10; ++$i) {
            self::assertTrue(\in_array($numberGenerator->randomNumber(0, 2), $expectedList, true));
        }
    }
}
