<?php


namespace Twc\BusBundle\Event\Interfaces;

interface EventBus
{
    public function dispatch(Event $event): void;
}
