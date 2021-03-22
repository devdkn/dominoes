<?php

declare(strict_types=1);

namespace AppTest\unit\Game\Condition;

use App\Board\Board;
use App\Game\Condition\EndGameConditionDetector;
use App\Player\PlayerInfoInterface;
use App\Tile\TileSet;
use PHPUnit\Framework\TestCase;

class EndGameConditionDetectorTest extends TestCase
{
    /**
     * PHPUnit dataProvider
     * @return array[]
     */
    public function getIsWinnerTestCases(): array
    {
        return [
            [1, false],
            [0, true],
        ];
    }

    /**
     * @dataProvider getIsWinnerTestCases
     *
     * @param int  $playerTiles
     * @param bool $expectedResult
     */
    public function testIsWinner(int $playerTiles, bool $expectedResult): void
    {
        $tileSet = $this->createTileSet();
        $tileSet->method('count')->willReturn($playerTiles);

        $player = $this->createPlayerInfo();
        $player->method('getPlayersTiles')->willReturn($tileSet);

        $detector = new EndGameConditionDetector(1);
        self::assertSame($expectedResult, $detector->isWinner($player));
    }

    public function testIsBlockedOnlyRight(): void
    {
        $uniqueValuesPerTile = 7;
        $rightValue = 1;
        $leftValue = 3;

        $rightCount = 8;
        $leftCount = 3;

        $board = $this->createBoard();
        $board->method('getRightValue')->willReturn($rightValue);
        $board->method('getLeftValue')->willReturn($leftValue);
        $board
            ->method('getValueCount')
            ->withConsecutive([$rightValue], [$leftValue])
            ->willReturnOnConsecutiveCalls($rightCount, $leftCount);

        $detector = new EndGameConditionDetector($uniqueValuesPerTile);
        self::assertFalse($detector->isBlocked($board));
    }

    public function testIsBlockedOnlyLeft(): void
    {
        $uniqueValuesPerTile = 7;
        $rightValue = 1;

        $rightCount = 6;

        $board = $this->createBoard();
        $board->method('getRightValue')->willReturn($rightValue);
        $board
            ->method('getValueCount')
            ->with($rightValue)
            ->willReturn($rightCount);

        $detector = new EndGameConditionDetector($uniqueValuesPerTile);
        self::assertFalse($detector->isBlocked($board));
    }

    public function testIsBlockedTrue(): void
    {
        $uniqueValuesPerTile = 7;
        $rightValue = 1;
        $leftValue = 3;

        $rightCount = 8;
        $leftCount = 8;

        $board = $this->createBoard();
        $board->method('getRightValue')->willReturn($rightValue);
        $board->method('getLeftValue')->willReturn($leftValue);
        $board
            ->method('getValueCount')
            ->withConsecutive([$rightValue], [$leftValue])
            ->willReturnOnConsecutiveCalls($rightCount, $leftCount);

        $detector = new EndGameConditionDetector($uniqueValuesPerTile);
        self::assertTrue($detector->isBlocked($board));
    }

    private function createBoard()
    {
        return $this->createMock(Board::class);
    }

    private function createTileSet()
    {
        return $this->createMock(TileSet::class);
    }

    private function createPlayerInfo()
    {
        return $this->createMock(PlayerInfoInterface::class);
    }
}
