<?php

declare(strict_types=1);

namespace AppTest\unit\EventHandler;

use App\Board\Board;
use App\EventHandler\Output\Formatter;
use App\EventHandler\OutputLogHandler;
use App\Game\Stats\Stats;
use App\Game\Stats\StatsItem;
use App\Move\MoveResult\AddLeftResult;
use App\Move\MoveResult\AddRightResult;
use App\Move\MoveResult\MoveResultInterface;
use App\Move\MoveResult\PickStockResult;
use App\Move\MoveResult\SkipResult;
use App\Output\OutputInterface;
use App\Player\PlayerInfoInterface;
use App\Tile\Tile;
use PHPUnit\Framework\TestCase;

class OutputLogEventHandlerTest extends TestCase
{
    public function testOnBoardInitializedByPlayer(): void
    {
        $tile = $this->createTile();

        $board = $this->createBoard();
        $board->method('getLeft')->willReturn($tile);

        $player = $this->createNotCallablePlayerInfoInterface();

        $formatter = $this->createFormatter();
        $formatter->method('formatPlayer')->with(self::identicalTo($player))->willReturn('p-formatted');
        $formatter->method('formatTile')->with(self::identicalTo($tile))->willReturn('t-formatted');

        $output = $this->createOutputInterface();
        $output
            ->expects(self::once())
            ->method('writeln')
            ->with('Player p-formatted has initialized the board with the t-formatted tile.');

        $handler = new OutputLogHandler($output, $formatter);
        $handler->onBoardInitializedByPlayer($board, $player);
    }

    public function testOnBoardInitializedFromStock(): void
    {
        $tile = $this->createTile();

        $board = $this->createBoard();
        $board->method('getLeft')->willReturn($tile);

        $formatter = $this->createFormatter();
        $formatter->method('formatTile')->with(self::identicalTo($tile))->willReturn('t-formatted');

        $output = $this->createOutputInterface();
        $output
            ->expects(self::once())
            ->method('writeln')
            ->with('The board has been initialized from the stock with the t-formatted tile.');

        $handler = new OutputLogHandler($output, $formatter);
        $handler->onBoardInitializedFromStock($board);
    }

    public function testHandleGameEndWinner(): void
    {
        $winner = $this->createNotCallablePlayerInfoInterface();

        $player1 = $this->createNotCallablePlayerInfoInterface();
        $player2 = $this->createNotCallablePlayerInfoInterface();

        $statItem1 = $this->createStatItem();
        $statItem1->method('getPlayerInfo')->willReturn($player1);
        $statItem1->method('getSum')->willReturn(3);

        $statItem2 = $this->createStatItem();
        $statItem2->method('getPlayerInfo')->willReturn($player2);
        $statItem2->method('getSum')->willReturn(10);

        $stats = $this->createStats();
        $stats->method('getWinner')->willReturn($winner);
        $stats->method('getItems')->willReturn([$statItem1, $statItem2]);

        $formatter = $this->createFormatter();
        $formatter
            ->method('formatPlayer')
            ->withConsecutive([self::identicalTo($winner)], [self::identicalTo($player1)], [self::identicalTo($player2)])
            ->willReturnOnConsecutiveCalls('p-formatted-winner', 'p-formatted-1', 'p-formatted-2');

        $output = $this->createOutputInterface();
        $output
            ->expects(self::exactly(4))
            ->method('writeln')
            ->withConsecutive(
                ['Game ended: p-formatted-winner wins!'],
                ['Stats:'],
                ['p-formatted-1 - 3'],
                ['p-formatted-2 - 10'],
            );

        $handler = new OutputLogHandler($output, $formatter);
        $handler->handleGameEndWinner($stats);
    }

    public function testHandleGameEndBlocked(): void
    {
        $blocker = $this->createNotCallablePlayerInfoInterface();

        $winner = $this->createNotCallablePlayerInfoInterface();

        $player1 = $this->createNotCallablePlayerInfoInterface();
        $player2 = $this->createNotCallablePlayerInfoInterface();

        $statItem1 = $this->createStatItem();
        $statItem1->method('getPlayerInfo')->willReturn($player1);
        $statItem1->method('getSum')->willReturn(3);

        $statItem2 = $this->createStatItem();
        $statItem2->method('getPlayerInfo')->willReturn($player2);
        $statItem2->method('getSum')->willReturn(10);

        $stats = $this->createStats();
        $stats->method('getWinner')->willReturn($winner);
        $stats->method('getItems')->willReturn([$statItem1, $statItem2]);

        $formatter = $this->createFormatter();
        $formatter
            ->method('formatPlayer')
            ->withConsecutive(
                [self::identicalTo($blocker)],
                [self::identicalTo($winner)],
                [self::identicalTo($player1)],
                [self::identicalTo($player2)]
            )
            ->willReturnOnConsecutiveCalls('p-blocker', 'p-formatted-winner', 'p-formatted-1', 'p-formatted-2');

        $output = $this->createOutputInterface();
        $output
            ->expects(self::exactly(5))
            ->method('writeln')
            ->withConsecutive(
                ['Game ended: p-blocker has blocked the board.'],
                ['The winner is p-formatted-winner.'],
                ['Stats:'],
                ['p-formatted-1 - 3'],
                ['p-formatted-2 - 10'],
            );

        $handler = new OutputLogHandler($output, $formatter);
        $handler->handleGameEndBlocked($blocker, $stats);
    }

    public function testHandleMoveResult(): void
    {
        $player = $this->createNotCallablePlayerInfoInterface();

        $output = $this->createOutputInterface();
        $output->expects(self::never())->method(self::anything());

        $formatter = $this->createFormatter();
        $formatter->expects(self::never())->method(self::anything());

        $handler = new OutputLogHandler($output, $formatter);

        $moveResult = $this->createMoveResultInterface();
        $moveResult
            ->expects(self::once())
            ->method('accept')
            ->with(self::identicalTo($player), self::identicalTo($handler));

        $handler->handleMoveResult($player, $moveResult);
    }

    public function testVisitAddLeftResult(): void
    {
        $player = $this->createNotCallablePlayerInfoInterface();

        $left = $this->createTile();
        $oldLeft = $this->createTile();

        $tile1 = $this->createTile();
        $tile2 = $this->createTile();

        $board = $this->createBoard();
        $board->method('getLeft')->willReturn($left);
        $board->method('getTilesIterator')->willReturn(new \ArrayIterator([$tile1, $tile2]));

        $result = $this->createAddLeftResult();
        $result->method('getBoard')->willReturn($board);
        $result->method('getOldLeft')->willReturn($oldLeft);

        $formatter = $this->createFormatter();
        $formatter->method('formatTile')->willReturnMap(
            [
                [$left, 'formatted-new'],
                [$oldLeft, 'formatted-old'],
            ]
        );
        $formatter->method('formatPlayer')->with(self::identicalTo($player))->willReturn('formatted-player');
        $formatter
            ->method('formatTiles')
            ->with(self::identicalTo($tile1), self::identicalTo($tile2))
            ->willReturn('formatted-board-tiles');

        $output = $this->createOutputInterface();
        $output
            ->expects(self::exactly(2))
            ->method('writeln')
            ->withConsecutive(
                ['formatted-player plays formatted-new to connect to tile formatted-old on the board'],
                ['Board is now: formatted-board-tiles']
            );

        $handler = new OutputLogHandler($output, $formatter);
        $handler->visitAddLeftResult($player, $result);
    }

    public function testVisitAddRightResult(): void
    {
        $player = $this->createNotCallablePlayerInfoInterface();

        $Right = $this->createTile();
        $oldRight = $this->createTile();

        $tile1 = $this->createTile();
        $tile2 = $this->createTile();

        $board = $this->createBoard();
        $board->method('getRight')->willReturn($Right);
        $board->method('getTilesIterator')->willReturn(new \ArrayIterator([$tile1, $tile2]));

        $result = $this->createAddRightResult();
        $result->method('getBoard')->willReturn($board);
        $result->method('getOldRight')->willReturn($oldRight);

        $formatter = $this->createFormatter();
        $formatter->method('formatTile')->willReturnMap(
            [
                [$Right, 'formatted-new'],
                [$oldRight, 'formatted-old'],
            ]
        );
        $formatter->method('formatPlayer')->with(self::identicalTo($player))->willReturn('formatted-player');
        $formatter
            ->method('formatTiles')
            ->with(self::identicalTo($tile1), self::identicalTo($tile2))
            ->willReturn('formatted-board-tiles');

        $output = $this->createOutputInterface();
        $output
            ->expects(self::exactly(2))
            ->method('writeln')
            ->withConsecutive(
                ['formatted-player plays formatted-new to connect to tile formatted-old on the board'],
                ['Board is now: formatted-board-tiles']
            );

        $handler = new OutputLogHandler($output, $formatter);
        $handler->visitAddRightResult($player, $result);
    }

    public function testVisitPickStockResult(): void
    {
        $player = $this->createNotCallablePlayerInfoInterface();
        $tile = $this->createTile();
        $result = $this->createPickStockResult();
        $result->method('getPickedTile')->willReturn($tile);

        $formatter = $this->createFormatter();
        $formatter->method('formatPlayer')->with(self::identicalTo($player))->willReturn('formatted-p');
        $formatter->method('formatTile')->with(self::identicalTo($tile))->willReturn('formatted-t');

        $output = $this->createOutputInterface();
        $output
            ->expects(self::once())
            ->method('writeln')
            ->with('formatted-p can\'t play, drawing tile formatted-t');


        $handler = new OutputLogHandler($output, $formatter);
        $handler->visitPickStockResult($player, $result);
    }

    public function testVisitSkipResult(): void
    {
        $player = $this->createNotCallablePlayerInfoInterface();
        $result = $this->createSkipResult();

        $formatter = $this->createFormatter();
        $formatter->method('formatPlayer')->with(self::identicalTo($player))->willReturn('formatted-p');

        $output = $this->createOutputInterface();
        $output
            ->expects(self::once())
            ->method('writeln')
            ->with('formatted-p skips');

        $handler = new OutputLogHandler($output, $formatter);
        $handler->visitSkipResult($player, $result);
    }

    private function createSkipResult()
    {
        return $this->createMock(SkipResult::class);
    }

    private function createPickStockResult()
    {
        return $this->createMock(PickStockResult::class);
    }

    private function createAddRightResult()
    {
        return $this->createMock(AddRightResult::class);
    }

    private function createAddLeftResult()
    {
        return $this->createMock(AddLeftResult::class);
    }

    private function createMoveResultInterface()
    {
        return $this->createMock(MoveResultInterface::class);
    }

    private function createStats()
    {
        return $this->createMock(Stats::class);
    }

    private function createStatItem()
    {
        return $this->createMock(StatsItem::class);
    }

    private function createTile()
    {
        return $this->createMock(Tile::class);
    }

    private function createBoard()
    {
        return $this->createMock(Board::class);
    }

    private function createNotCallablePlayerInfoInterface()
    {
        $mock = $this->createMock(PlayerInfoInterface::class);
        $mock->expects(self::never())->method(self::anything());

        return $mock;
    }

    private function createOutputInterface()
    {
        return $this->createMock(OutputInterface::class);
    }

    private function createFormatter()
    {
        return $this->createMock(Formatter::class);
    }
}
