<?php

namespace Twc\BusBundle\Command;

use Twc\BusBundle\Command\Interfaces\CommandBusMiddleware;

class CommandBusFactory
{
    public static function build(iterable $handlers, iterable $middlewares): CommandBusMiddleware
    {
        $bus = new CommandBusDispatcher($handlers);
        /** @var CommandBusMiddleware $middleware */
        foreach ($middlewares as $middleware) {
            $bus = $middleware->appendMiddleware($bus);
        }

        return $bus;
    }
}
