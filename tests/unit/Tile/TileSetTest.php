<?php

declare(strict_types=1);

namespace AppTest\unit\Tile;

use App\Tile\Tile;
use App\Tile\TileSet;
use PHPUnit\Framework\TestCase;

class TileSetTest extends TestCase
{
    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testAddAndCountable(): void
    {
        $t1 = new Tile(1, 2);
        $t2 = new Tile(2, 1);
        $t3 = new Tile(2, 2);
        $t4 = new Tile(\PHP_INT_MIN, -1);

        $collection = new TileSet();
        $collection->add($t1);
        $collection->add($t2);
        self::assertCount(1, $collection);

        $collection->add($t3);
        self::assertCount(2, $collection);

        $collection->add($t4);
        self::assertCount(3, $collection);
    }

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testPop(): void
    {
        $t1 = new Tile(1, 2);
        $t2 = new Tile(2, 2);

        $collection = new TileSet();
        $collection->add($t1);
        $collection->add($t2);
        self::assertCount(2, $collection);

        self::assertSame($t2, $collection->pop());
        self::assertCount(1, $collection);
        self::assertSame($t1, $collection->pop());
        self::assertCount(0, $collection);
        self::assertNull($collection->pop());
        self::assertCount(0, $collection);
    }

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testPopN(): void
    {
        $t1 = new Tile(1, 2);
        $t2 = new Tile(2, 2);
        $t3 = new Tile(3, 2);
        $t4 = new Tile(4, 2);

        $collection = new TileSet();
        $collection->add($t1);
        $collection->add($t2);
        $collection->add($t3);
        $collection->add($t4);

        $new1 = $collection->popN(2);
        self::assertCount(2, $new1);
        self::assertCount(2, $collection);
        self::assertSame($t4, $new1->pop());
        self::assertSame($t3, $new1->pop());

        $new2 = $collection->popN(3);
        self::assertCount(2, $new2);
        self::assertCount(0, $collection);
        self::assertSame($t2, $new2->pop());
        self::assertSame($t1, $new2->pop());

        self::assertCount(0, $collection->popN(1));
    }

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testSumValues(): void
    {
        $collection = new TileSet();
        self::assertSame(0, $collection->sumValues());

        $t1 = new Tile(1, 2);
        $t2 = new Tile(2, 2);
        $collection->add($t1);
        self::assertSame(3, $collection->sumValues());

        $collection->add($t2);
        self::assertSame(7, $collection->sumValues());

        $collection->pop();
        self::assertSame(3, $collection->sumValues());
    }

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testRemove(): void
    {
        $collection = new TileSet();

        $t1 = new Tile(1, 2);
        $t2 = new Tile(2, 1);
        $t3 = new Tile(2, 2);
        $collection->add($t1);
        $collection->add($t3);

        self::assertCount(2, $collection);
        $collection->remove($t2);
        self::assertCount(1, $collection);

        $collection->remove($t1);
        self::assertCount(1, $collection);
    }

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testFilterByValue(): void
    {
        $collection = new TileSet();

        $t1 = new Tile(1, 2);
        $t2 = new Tile(2, 2);
        $t3 = new Tile(3, 2);
        $t4 = new Tile(4, 3);
        $collection->add($t1);
        $collection->add($t2);
        $collection->add($t3);
        $collection->add($t4);

        self::assertCount(4, $collection);

        $filtered1 = $collection->filterByValue(1);
        self::assertCount(4, $collection);
        self::assertCount(1, $filtered1);
        self::assertSame($t1, $filtered1->pop());

        $filtered3 = $collection->filterByValue(3);
        self::assertCount(4, $collection);
        self::assertCount(2, $filtered3);
        self::assertSame($t4, $filtered3->pop());
        self::assertSame($t3, $filtered3->pop());
    }
}
