<?php

namespace Twc\BusBundle\Command\Interfaces;

use Twc\BusBundle\Command\CommandResponse;

interface CommandBusMiddleware
{
    public function dispatch(Command $command): CommandResponse;

    public function appendMiddleware(CommandBusMiddleware $next): self;
}
