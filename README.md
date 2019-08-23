# TwcBusBundle

Provide simple way to implement Message Bus concept in Symfony 4.

## Before start 

Thank's [@lilobase](https://twitter.com/Lilobase) for you excellent talk at [PHP TOUR 2018](https://afup.org/talks/2628-cqrs-fonctionnel-event-sourcing-domain-driven-design).

Thank's [@matGiWeb](https://twitter.com/matGiWeb) for you approach with [cqrs-skeleton](https://github.com/magi-web/cqrs-skeleton)

## Remember

CQRS (Command Query Responsibility Segregation) it's an architectural pattern that aims to separate the **writing** (Command) and **reading** (Query).

## Pré-requis

symfony powerfull DI with autowire and autoconfigure enable

```
services:

    # default configuration for services in *this* file
    _defaults:
        autowire: true      # Automatically injects dependencies in your services.
        autoconfigure: true # Automatically registers your services as commands, event subscribers, etc.
        public: false

```


## Installation

```

composer require twc/bus-bundle

```


## How to use ?

If you know CQRS pattern, you only have to implement the desired interface

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

## About Bus

| topic  | Interface |
|--------|-----------|
| CommandBusDispatcher | Twc\BusBundle\Command\CommandBusDispatcher |
| EventBusDispatcher | Twc\BusBundle\Event\EventBusDispatcher |
| QueryBusDispatcher | Twc\BusBundle\Query\QueryBusDispatcher |


That's all !
 
CommandBus, EventBus, QueryBus will do the work, thank's Dependencies Injection and autowiring in symfony.

# Samples

- [exemple (fr)](./docs/cqrs_fr.md)


