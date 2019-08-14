<?php

namespace Twc\BusBundle\Event;

use Twc\BusBundle\Event\Interfaces\Event;
use Twc\BusBundle\Event\Interfaces\EventBus;

class EventBusDispatcher implements EventBus
{
    private $handlers;

    public function __construct(iterable $handlers)
    {
        foreach ($handlers as $handler) {
            $this->handlers[] = $handler;
        }
    }

    public function dispatch(Event $event): void
    {
        $eventClass = get_class($event);

        $runnableHandlers = array_filter($this->handlers, function ($handler) use ($eventClass) {
            return $handler->listenTo() == $eventClass;
        });

        if (is_array($runnableHandlers)) {
            foreach ($runnableHandlers as $handler) {
                $handler->handle($event);
            }
        }

    }

}