<?php
declare(strict_types=1);

namespace Twc\BusBundle\Query;

use Twc\BusBundle\Query\Interfaces\Query;

class QueryBusDispatcher
{
    private $handlers;

    public function __construct(iterable $handlers)
    {
        $this->handlers = [];
        foreach ($handlers as $handler) {
            $this->handlers[$handler->listenTo()] = $handler;
        }
    }

    /**
     * @param Query $query
     *
     * @return array
     */
    public function dispatch(Query $query): array
    {
        $queryClass = get_class($query);
        if (false === array_key_exists($queryClass, $this->handlers)) {
            throw new \LogicException("No handler found for $queryClass");
        }
        $handler = $this->handlers[$queryClass];
        return $handler->handle($query);
    }
}
