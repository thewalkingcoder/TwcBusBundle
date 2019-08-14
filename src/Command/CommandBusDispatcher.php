<?php

namespace Twc\BusBundle\Command;

use Twc\BusBundle\Command\Interfaces\Command;
use Twc\BusBundle\Command\Interfaces\CommandBusMiddleware;


final class CommandBusDispatcher extends CommandBus implements CommandBusMiddleware
{
    private $handlers;

    public function __construct(iterable $handlers)
    {
        $this->handlers = [];

        foreach ($handlers as $handler) {
            $this->handlers[$handler->listenTo()] = $handler;
        }

    }

    public function dispatch(Command $command): CommandResponse
    {
        $commandClass = get_class($command);

        if (false === array_key_exists($commandClass, $this->handlers)) {
            throw new \LogicException("Handler for command $commandClass not found");
        }
        $handler = $this->handlers[$commandClass];
        return $handler->handle($command);
    }

    public function appendMiddleware(CommandBusMiddleware $next): CommandBusMiddleware
    {
        return $this;
    }

}