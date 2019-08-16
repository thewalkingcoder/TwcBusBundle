# TwcBusBundle

Provide simple way to implement Message Bus concept in Symfony 4.

## Before start 

Thank's [@lilobase](https://twitter.com/Lilobase) for you excellent talk at [PHP TOUR 2018](https://afup.org/talks/2628-cqrs-fonctionnel-event-sourcing-domain-driven-design).

Thank's [@matGiWeb](https://twitter.com/matGiWeb) for you approach with [cqrs-skeleton](https://github.com/magi-web/cqrs-skeleton)

## Remember

CQRS (Command Query Responsibility Segregation) it's an architectural pattern that aims to separate the **writing** (Command) and **reading** (Query).

## Pré-requis

Autowiring

## Installation

```

composer require twc/bus-bundle

```

Active bundle

```
//config/bundle.php

Twc\BusBundle\TwcBusBundle::class => ['all' => true]

```

## How to use ?

You only have to implement the desired interface

### About Commands

| topic  | Interface |
|--------|-----------|
| Command | Twc\BusBundle\Command\Interfaces\Command |
| CommandHandler | Twc\BusBundle\Command\Interfaces\CommandHandler |
| Middleware | Twc\BusBundle\Command\Interfaces\CommandBusMiddleware |

### About Events

| topic  | Interface |
|--------|-----------|
| Event | Twc\BusBundle\Event\Interfaces\Event |
| EventHandler | Twc\BusBundle\Event\Interfaces\EventHandler |

### About Queries

| topic  | Interface |
|--------|-----------|
| Query | Twc\BusBundle\Query\Interfaces\Query |
| QueryHandler | Twc\BusBundle\Event\Interfaces\QueryHandler |

That's all !
 
CommandBus, EventBus, QueryBus will do the work, thank's Dependencies Injection and autowiring in symfony.




