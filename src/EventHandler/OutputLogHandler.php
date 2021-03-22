<?php

declare(strict_types=1);

namespace App\EventHandler;

use App\Board\Board;
use App\EventHandler\Output\Formatter;
use App\Game\Stats\Stats;
use App\Move\MoveResult\AddLeftResult;
use App\Move\MoveResult\AddRightResult;
use App\Move\MoveResult\MoveResultInterface;
use App\Move\MoveResult\PickStockResult;
use App\Move\MoveResult\SkipResult;
use App\Output\OutputInterface;
use App\Player\PlayerInfoInterface;

class OutputLogHandler implements EventHandlerInterface
{
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var Formatter
     */
    private $formatter;

    /**
     * @param OutputInterface $output
     * @param Formatter       $formatter
     */
    public function __construct(OutputInterface $output, Formatter $formatter)
    {
        $this->output = $output;
        $this->formatter = $formatter;
    }

    /**
     * {@inheritdoc}
     */
    public function onBoardInitializedByPlayer(Board $board, PlayerInfoInterface $player): void
    {
        $this->output->writeln(
            'Player ' . $this->formatter->formatPlayer($player) . ' has initialized the board with the '
            . $this->formatter->formatTile($board->getLeft()) . ' tile.'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function onBoardInitializedFromStock(Board $board): void
    {
        $this->output->writeln(
            'The board has been initialized from the stock with the ' . $this->formatter->formatTile($board->getLeft())
            . ' tile.'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function handleGameEndWinner(Stats $stats): void
    {
        $this->output->writeln('Game ended: ' . $this->formatter->formatPlayer($stats->getWinner()) . ' wins!');
        $this->outputStats($stats);
    }

    /**
     * {@inheritdoc}
     */
    public function handleGameEndBlocked(PlayerInfoInterface $blocker, Stats $stats): void
    {
        $this->output->writeln('Game ended: ' . $this->formatter->formatPlayer($blocker) . ' has blocked the board.');
        $this->output->writeln('The winner is ' . $this->formatter->formatPlayer($stats->getWinner()) . '.');
        $this->outputStats($stats);
    }

    /**
     * @param Stats $stats
     */
    private function outputStats(Stats $stats): void
    {
        $this->output->writeln('Stats:');
        foreach ($stats->getItems() as $item) {
            $this->output->writeln(
                $this->formatter->formatPlayer($item->getPlayerInfo()) . " - " . $item->getSum()
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function handleMoveResult(PlayerInfoInterface $player, MoveResultInterface $moveResult): void
    {
        $moveResult->accept($player, $this);
    }

    /**
     * {@inheritdoc}
     */
    public function visitAddLeftResult(PlayerInfoInterface $player, AddLeftResult $result): void
    {
        $board = $result->getBoard();

        $newTile = $this->formatter->formatTile($board->getLeft());
        $oldTile = $this->formatter->formatTile($result->getOldLeft());
        $playerStr = $this->formatter->formatPlayer($player);

        $this->output->writeln(
            $playerStr . ' plays ' . $newTile . ' to connect to tile ' . $oldTile . ' on the board'
        );
        $this->output->writeln(
            'Board is now: ' . $this->formatter->formatTiles(...$board->getTilesIterator())
        );
    }

    /**
     * {@inheritdoc}
     */
    public function visitAddRightResult(PlayerInfoInterface $player, AddRightResult $result): void
    {
        $board = $result->getBoard();

        $newTile = $this->formatter->formatTile($board->getRight());
        $oldTile = $this->formatter->formatTile($result->getOldRight());
        $playerStr = $this->formatter->formatPlayer($player);

        $this->output->writeln(
            $playerStr . ' plays ' . $newTile . ' to connect to tile ' . $oldTile . ' on the board'
        );
        $this->output->writeln(
            'Board is now: ' . $this->formatter->formatTiles(...$board->getTilesIterator())
        );
    }

    /**
     * {@inheritdoc}
     */
    public function visitPickStockResult(PlayerInfoInterface $player, PickStockResult $result): void
    {
        $playerStr = $this->formatter->formatPlayer($player);
        $tile = $this->formatter->formatTile($result->getPickedTile());

        $this->output->writeln($playerStr . ' can\'t play, drawing tile ' . $tile);
    }

    /**
     * {@inheritdoc}
     */
    public function visitSkipResult(PlayerInfoInterface $player, SkipResult $result): void
    {
        $this->output->writeln($this->formatter->formatPlayer($player) . ' skips');
    }
}
