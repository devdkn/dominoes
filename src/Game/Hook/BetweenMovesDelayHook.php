<?php

declare(strict_types=1);

namespace App\Game\Hook;

use App\Util\DelayService;

class BetweenMovesDelayHook implements BetweenMovesHookInterface
{
    /**
     * @var DelayService
     */
    private $delayService;

    /**
     * @var int
     */
    private $delay;

    /**
     * @param DelayService $delayService
     * @param int          $delay        Delay between moves in seconds.
     */
    public function __construct(DelayService $delayService, int $delay)
    {
        $this->delayService = $delayService;
        $this->delay = $delay;
    }

    /**
     * {@inheritdoc}
     */
    public function beforeNextMove(): void
    {
        $this->delayService->sleep($this->delay);
    }
}
