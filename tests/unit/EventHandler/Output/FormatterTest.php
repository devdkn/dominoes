<?php

declare(strict_types=1);

namespace AppTest\unit\EventHandler\Output;

use App\EventHandler\Output\Formatter;
use App\Player\PlayerInfoInterface;
use App\Tile\Tile;
use App\Tile\TileSet;
use PHPUnit\Framework\TestCase;

class FormatterTest extends TestCase
{
    public function testFormatPlayer(): void
    {
        $tileSet = $this->createTileSet();
        $tileSet->method('count')->willReturn(3);

        $player = $this->createPlayerInfoInterface();
        $player->method('getName')->willReturn('name');
        $player->method('getPlayersTiles')->willReturn($tileSet);

        $formatter = new Formatter();
        $res = $formatter->formatPlayer($player);
        self::assertSame('name (3)', $res);
    }

    public function testFormatTile(): void
    {
        $tile = $this->createTile();
        $tile->method('__toString')->willReturn('tile-string');

        $formatter = new Formatter();
        $res = $formatter->formatTile($tile);
        self::assertSame('<tile-string>', $res);
    }

    public function testFormatTiles(): void
    {
        $tile1 = $this->createTile();
        $tile1->method('__toString')->willReturn('tile-string-1');

        $tile2 = $this->createTile();
        $tile2->method('__toString')->willReturn('tile-string-2');

        $formatter = new Formatter();
        $res = $formatter->formatTiles($tile1, $tile2);
        self::assertSame('<tile-string-1> <tile-string-2>', $res);
    }

    private function createTileSet()
    {
        return $this->createMock(TileSet::class);
    }

    private function createTile()
    {
        return $this->createMock(Tile::class);
    }

    private function createPlayerInfoInterface()
    {
        return $this->createMock(PlayerInfoInterface::class);
    }
}
