<?php

declare(strict_types=1);

namespace App\Move\MoveResult;

use App\Player\PlayerInfoInterface;

interface MoveResultVisitorInterface
{
    /**
     * @param PlayerInfoInterface $player
     * @param AddLeftResult       $result
     */
    public function visitAddLeftResult(PlayerInfoInterface $player, AddLeftResult $result): void;

    /**
     * @param PlayerInfoInterface $player
     * @param AddRightResult      $result
     */
    public function visitAddRightResult(PlayerInfoInterface $player, AddRightResult $result): void;

    /**
     * @param PlayerInfoInterface $player
     * @param PickStockResult     $result
     */
    public function visitPickStockResult(PlayerInfoInterface $player, PickStockResult $result): void;

    /**
     * @param PlayerInfoInterface $player
     * @param SkipResult          $result
     */
    public function visitSkipResult(PlayerInfoInterface $player, SkipResult $result): void;
}
