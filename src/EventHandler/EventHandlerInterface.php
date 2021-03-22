<?php

declare(strict_types=1);

namespace App\EventHandler;

use App\Board\Initializer\EventHandler\BoardEventHandlerInterface;
use App\Game\EventHandler\GameEventHandlerInterface;

interface EventHandlerInterface extends BoardEventHandlerInterface, GameEventHandlerInterface
{
}
