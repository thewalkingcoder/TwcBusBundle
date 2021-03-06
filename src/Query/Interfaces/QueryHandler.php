<?php

namespace Twc\BusBundle\Query\Interfaces;

interface QueryHandler
{
    public function handle(Query $query);

    public function listenTo(): string;
}
