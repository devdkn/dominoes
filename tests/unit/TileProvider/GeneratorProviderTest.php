<?php

declare(strict_types=1);

namespace AppTest\unit\TileProvider;

use App\TileProvider\GeneratorProvider;
use PHPUnit\Framework\TestCase;

class GeneratorProviderTest extends TestCase
{
    public function testProvideTilesException(): void
    {
        $this->expectException(\LogicException::class);

        $provider = new GeneratorProvider();
        $provider->provideTiles(0);
    }

    /**
     * PHPUnit dataProvider
     * @return array[]
     */
    public function getProvideTilesTestCases(): array
    {
        return [
            [
                1,
                ['0:0'],
            ],
            [
                2,
                ['0:0', '0:1', '1:1'],
            ],
            [
                3,
                ['0:0', '0:1', '0:2', '1:1', '1:2', '2:2'],
            ]
        ];
    }

    /**
     * @dataProvider getProvideTilesTestCases
     *
     * @param int   $values
     * @param array $expectedTiles
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testProvideTiles(int $values, array $expectedTiles): void
    {
        $provider = new GeneratorProvider();
        $res = $provider->provideTiles($values);

        $stringList = [];
        while (($tile = $res->pop()) !== null) {
            $stringList[] = $tile->getLeft() . ':' . $tile->getRight();
        }
        self::assertEqualsCanonicalizing($expectedTiles, $stringList);
    }
}
