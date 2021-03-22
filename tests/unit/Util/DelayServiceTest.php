<?php

declare(strict_types=1);

namespace AppTest\unit\Util;

use App\Util\DelayService;
use PHPUnit\Framework\TestCase;

class DelayServiceTest extends TestCase
{
    public function testSleep(): void
    {
        $delayService = new DelayService();
        $initialTime = time();
        $delayService->sleep(1);
        self::assertGreaterThanOrEqual(1, time() - $initialTime);
    }
}
