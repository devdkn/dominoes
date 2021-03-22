<?php

declare(strict_types=1);

namespace AppTest\unit\Board\Initializer;

use App\Board\Board;
use App\Board\BoardFactory;
use App\Board\Initializer\EventHandler\BoardEventHandlerInterface;
use App\Board\Initializer\RandomPlayerTileInitializer;
use App\Player\Player;
use App\Player\PlayersSet;
use App\Tile\Tile;
use App\Tile\TileSet;
use App\Util\NumberGenerator;
use PHPUnit\Framework\TestCase;

class RandomPlayerInitializerTest extends TestCase
{
    public function testInitializeCurrentWithNoTiles(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessageMatches('/player-name/');

        $numberGenerator = $this->createNumberGenerator();
        $numberGenerator->method('randomNumber')->with(0, 1)->willReturn(0);

        $stock = $this->createTileSet();
        $stock->expects(self::never())->method(self::anything());

        $tileSet = $this->createTileSet();
        $tileSet->method('pop')->willReturn(null);

        $player = $this->createPlayer();
        $player->method('getPlayersTiles')->willReturn($tileSet);
        $player->method('getName')->willReturn('player-name');

        $players = $this->createPlayersSet();
        $players->method('current')->willReturn($player);

        $handler = $this->createBoardEventHandlerInterface();
        $handler->expects(self::never())->method(self::anything());

        $factory = $this->createBoardFactory();
        $factory->expects(self::never())->method(self::anything());

        $initializer = new RandomPlayerTileInitializer($factory, $numberGenerator, $handler);
        $initializer->initialize($stock, $players);
    }

    public function testInitializeCurrent(): void
    {
        $numberGenerator = $this->createNumberGenerator();
        $numberGenerator->method('randomNumber')->with(0, 1)->willReturn(0);

        $stock = $this->createTileSet();
        $stock->expects(self::never())->method(self::anything());

        $tile = $this->createTile();
        $tile->expects(self::never())->method(self::anything());

        $tileSet = $this->createTileSet();
        $tileSet->method('pop')->willReturn($tile);

        $player = $this->createPlayer();
        $player->method('getPlayersTiles')->willReturn($tileSet);

        $nextPlayer = $this->createPlayer();
        $nextPlayer->expects(self::never())->method(self::anything());

        $players = $this->createPlayersSet();
        $players->method('current')->willReturn($player);
        $players->expects(self::once())->method('next')->willReturn($nextPlayer);

        $board = $this->createBoard();

        $factory = $this->createBoardFactory();
        $factory->method('createBoard')->with(self::identicalTo($tile))->willReturn($board);

        $handler = $this->createBoardEventHandlerInterface();
        $handler
            ->expects(self::once())
            ->method('onBoardInitializedByPlayer')
            ->with(self::identicalTo($board), self::identicalTo($player));

        $initializer = new RandomPlayerTileInitializer($factory, $numberGenerator, $handler);
        self::assertSame($board, $initializer->initialize($stock, $players));
    }

    public function getInitializeNextTestCases()
    {
        return [
            [1],
            [-1],
        ];
    }

    /**
     * @dataProvider getInitializeNextTestCases
     *
     * @param int $randomReturn
     */
    public function testInitializeNext(int $randomReturn): void
    {
        $numberGenerator = $this->createNumberGenerator();
        $numberGenerator->method('randomNumber')->with(0, 1)->willReturn($randomReturn);

        $stock = $this->createTileSet();
        $stock->expects(self::never())->method(self::anything());

        $tile = $this->createTile();
        $tile->expects(self::never())->method(self::anything());

        $tileSet = $this->createTileSet();
        $tileSet->method('pop')->willReturn($tile);

        $player = $this->createPlayer();
        $player->method('getPlayersTiles')->willReturn($tileSet);

        $nextPlayer = $this->createPlayer();
        $nextPlayer->expects(self::never())->method(self::anything());

        $players = $this->createPlayersSet();
        $players->method('next')->willReturnOnConsecutiveCalls($player, $nextPlayer);

        $board = $this->createBoard();

        $factory = $this->createBoardFactory();
        $factory->method('createBoard')->with(self::identicalTo($tile))->willReturn($board);

        $handler = $this->createBoardEventHandlerInterface();
        $handler
            ->expects(self::once())
            ->method('onBoardInitializedByPlayer')
            ->with(self::identicalTo($board), self::identicalTo($player));

        $initializer = new RandomPlayerTileInitializer($factory, $numberGenerator, $handler);
        self::assertSame($board, $initializer->initialize($stock, $players));
    }

    private function createBoardFactory()
    {
        return $this->createMock(BoardFactory::class);
    }

    private function createBoard()
    {
        return $this->createMock(Board::class);
    }

    private function createNumberGenerator()
    {
        return $this->createMock(NumberGenerator::class);
    }

    private function createTile()
    {
        return $this->createMock(Tile::class);
    }

    private function createPlayersSet()
    {
        return $this->createMock(PlayersSet::class);
    }

    private function createPlayer()
    {
        return $this->createMock(Player::class);
    }

    private function createTileSet()
    {
        return $this->createMock(TileSet::class);
    }

    private function createBoardEventHandlerInterface()
    {
        return $this->createMock(BoardEventHandlerInterface::class);
    }
}
