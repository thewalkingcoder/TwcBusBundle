<?php

namespace Twc\BusBundle\Command;

final class CommandResponse
{
    private $response;
    private $status;
    private $events;

    public function __construct($response, int $status = 200, ?iterable $events = null)
    {
        $this->response = $response;
        $this->status = $status;
        $this->events = $events;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return bool
     */
    public function hasEvents(): bool
    {
        return !empty($this->events);
    }

    /**
     * @return iterable|null
     */
    public function getEvents(): ?iterable
    {
        return $this->events;
    }
}
