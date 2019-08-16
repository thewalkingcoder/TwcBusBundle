<?php

namespace Twc\BusBundle\Event\Interfaces;

interface EventHandler
{
    public function handle($event): void;

    public function listenTo(): string;
}
