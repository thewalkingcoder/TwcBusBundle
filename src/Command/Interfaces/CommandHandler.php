<?php

namespace Twc\BusBundle\Command\Interfaces;

use Twc\BusBundle\Command\CommandResponse;

interface CommandHandler
{
    public function handle(Command $command): CommandResponse;

    public function listenTo(): string;
}
