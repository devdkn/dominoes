<?php

declare(strict_types=1);

namespace App\Util;

use App\Move\MoveInterface;
use App\Move\SkipMove;

class LoopDetector
{
    /**
     * @phpstan-var \SplDoublyLinkedList<string>
     * @var \SplDoublyLinkedList
     */
    private $logs;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): void
    {
        $this->logs = new \SplDoublyLinkedList();
    }

    /**
     * @param MoveInterface $move
     * @param int           $playersNumber
     */
    public function detectLoopCondition(MoveInterface $move, int $playersNumber): void
    {
        $this->logs->push(\get_class($move));
        $logsNumber = $this->logs->count();

        if ($logsNumber > $playersNumber) {
            $this->logs->shift();
            $blocked = true;
            foreach ($this->logs as $item) {
                if ($item !== SkipMove::class) {
                    $blocked = false;
                    break;
                }
            }
            if ($blocked) {
                throw new \LogicException('Infinite loop detected');
            }
        }
    }
}
