<?php

namespace Twc\BusBundle\Event;

use Twc\BusBundle\Command\CommandBus;
use Twc\BusBundle\Command\CommandResponse;
use Twc\BusBundle\Command\Interfaces\Command;
use Twc\BusBundle\Command\Interfaces\CommandBusMiddleware;

class EventBusDispatcherMiddleware extends CommandBus implements CommandBusMiddleware
{
    /**
     * @var EventBusDispatcher
     */
    private $eventBusDispatcher;

    private $bus;

    public function __construct(EventBusDispatcher $eventBusDispatcher)
    {
        $this->eventBusDispatcher = $eventBusDispatcher;
    }

    public function dispatch(Command $command): CommandResponse
    {
        $commandResponse = $this->bus->dispatch($command);
        if ($commandResponse->hasEvents() && is_array($commandResponse->getEvents())) {
            foreach ($commandResponse->getEvents() as $event) {
                $this->eventBusDispatcher->dispatch($event);
            }
        }
        return $commandResponse;
    }

    public function appendMiddleware(CommandBusMiddleware $next): CommandBusMiddleware
    {
        $this->bus = $next;
        return $this;
    }
}
