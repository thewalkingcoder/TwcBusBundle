<?php

namespace Twc\BusBundle\Command;

use Twc\BusBundle\Command\Interfaces\Command;
use Twc\BusBundle\Command\Interfaces\CommandBusMiddleware;

abstract class CommandBus implements CommandBusMiddleware
{
    abstract public function dispatch(Command $command): CommandResponse;
}