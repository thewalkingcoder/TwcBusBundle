<?php

namespace Twc\BusBundle\Query\Interfaces;

interface QueryHandler
{
    public function handle(Query $query): array;

    public function listenTo(): string;
}
