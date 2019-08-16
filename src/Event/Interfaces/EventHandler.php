<?php

namespace Twc\BusBundle\Event\Interfaces;

use Twc\BusBundle\Event\Interfaces\Event;

interface EventHandler
{
    public function handle($event): void;

    public function listenTo(): string;
}