# Exemple d'utilisation

## Commands

Une commande représente une intention utilisateur (un use case). C'est un simple DTO (Data transfert object) qui va être manipulé par la suite (Handler) afin de persister l'intention utilisateur.
Une fois la commande réalisée/manipulée elle peut potentionnellement déclencher des événements. (traitement annexe)

Imaginons un logiciel RH permettant l'enregistrement d'un nouveau employé. 
Un employé est défini par un nom, prenom, mail. 

Exemple de command

```
namespace App\Employee\Command;

use Twc\BusBundle\Command\Interfaces\Command;

final class CreateNewEmployee implements Command {

    private $name;
    private $firstName;
    private $mail;

    public function __construct(string $name, string $firstName, AddressMail $mail)
    {
        ...
    }
}


```

On va créer le handler associé et implémenter CommandHandler

```
namespace App\Employee\Command;

use Twc\BusBundle\Command\Interfaces\CommandHandler;

class CreateNewEmployeeHandler implements CommandeHandler{
 
   
}

```

Cette interface à 2 méthodes

### Méthode listenTo

Permet de rattacher le handler à une commande

```
    public function listenTo(): string
    {
        return createNewEmployee::class
    }

```

### Méthode handle

Déclenchera toutes les manipulations nécessaires jusqu'à la persistence.

```
...

class CreateNewEmployeeHandler implements CommandeHandler{

     public function handle(Command $command): CommandResponse
     {
        //call Domain, infrastructure ...

        return new CommandResponse(...);
     }
   
}

```

Une fois une commande validée, elle peut déclencher des traitements annexes (events). Dans notre exemple on va envoyer un mail.

## Events

Créer votre events sur le même principe qu'une command en implémentant l'interface qui va bien.

```
namespace App\Employee\Domain\Event;

use Twc\BusBundle\Event\Interfaces\Event;

final class SendWelcomeEmployeeMail implements Event {

    private $firstName;
    private $mail;

    public function __construct(string $firstName, AddressMail $mail)
    {
        ...
    }
}


```
**DDD**

Les puristes du DDD remarqueront un principe cassant, à savoir que les events font partie du Domaine, et que dans ce sens, le domaine ne doit pas être couplé au framework, librairie.

Pour respecter cette convention vous pouvez créer votre propre interface dans votre domaine et implémenter celle-ci.

Créer maintenant votre EventHandler qui enverra le mail

```
namespace App\Employee\Events;

use Twc\BusBundle\Event\Interfaces\Event;

class SendWelcomeEmployeeMailHandler implements EventHandler {

}


```
### Méthode listenTo

Permet de rattacher le handler à un event

```
    public function listenTo(): string
    {
        return SendWelcomeEmployeeMail::class
    }

```

### Méthode handle


```
...

class SendWelcomeEmployeeMailHandler implements EventHandler{

     public function handle($event): void
     {
         ....

        $message = "Welcome {$event->getFirstName()} !";

        $this->mailer->send($message);
     }
   
}

```

Maintenant il ne reste plus qu'a modifier votre command


```
...

class CreateNewEmployeeHandler implements CommandeHandler{

     public function handle(Command $command): CommandResponse
     {
        //call Domain, infrastructure ...

        $sendWelcomeEmployeeMail = new SendWelcomeEmployeeMail($employee->getFirstName(), $employee->getMail());

        return new CommandResponse(...,200, [$sendWelcomeEmployeeMail]);
     }
   
}

```

## Queries

Une query est une réprésentation en lecture seule des données.

Imaginons un moteur de recherche 

```
namespace App\Employee\Query;

use Twc\BusBundle\Query\Interfaces\Query;

class SearchEmployee implements Query{

     private $keywords;

     public function __construct(string $keywords) {
        ...
     }
   
}


```

Le QueryHandler ira directement chercher les informations sans passer par le repository

```
namespace App\Employee\Query;

use Twc\BusBundle\Query\Interfaces\QueryHandler;

class SearchEmployeeHandler implements QueryHandler{
     
   
}

```

### Méthode listenTo

Permet de rattacher le handler à une query

```
    public function listenTo(): string
    {
        return SearchEmployee::class
    }

```

### Méthode handle

```
...

class SearchEmployeeHandler implements QueryHandler{

     public function handle($query): array
     {
         ....

        $this->connection->prepare("
            SELECT * FROM employee
            WHERE firsName LIKE %:keyword%
        ");

        ...
        
     }
   
}

```

## Middlewares

Un middleware est un élement qui va venir s'intercaler avant/entre/après vos commandes.
Par exemple on souhaite que toutes les commandes avec persistance soient effectuées en transactionnel.


```
namespace App\Middlewares;

use Twc\BusBundle\Command\Interfaces\CommandBusMiddleware;
use Twc\BusBundle\Command\Command;
use Twc\BusBundle\Command\CommandBus;
use Twc\BusBundle\Command\CommandResponse;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineTransactionMiddleware extends CommandBus implements CommandBusMiddleware
{
     
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    function dispatch(Command $command): CommandResponse
    {
        $this->entityManager->getConnection()->beginTransaction();
        try {
            $response = $this->next->dispatch($command);
            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();
        } catch (\Exception $e) {
            $this->entityManager->getConnection()->rollBack();
            $response = new CommandResponse(null, 500);
        }
        return $response;
    }

    public function appendMiddleware(CommandBusMiddleware $next): CommandBusMiddleware
    {
        $this->bus = $next;
        return $this;
    }
}

```

## La tuyauterie

Il ne reste plus qu'à appeler les Bus qui s'occuperont de la tuyauterie, rien de plus simple

Exemple pour une command

```
namespace App\Employee\Presenter;
use Symfony\Component\HttpFoundation\Request;
use Twc\BusBundle\Command\CommandBus;


class EmployeeController extends AbstractController
{
    public function __construct(...CommandBus $commandBus)

    public function createNewEmployee(Request $request)
    {
        //call form, request etc...

        $newEmployee = new CreateNewEmployee(
            'SNOW',
            'JON',
            new AdressMail('jon.snow@got.com')
        );

       $commandResponse = $this->commandBus->dispatch($newEmployee);

       ...
    }
}


```

Même principe pour une query

```

namespace App\Employee\Presenter;
use Symfony\Component\HttpFoundation\Request;
use Twc\BusBundle\Query\QueryBusDispatcher;


class EmployeeController extends AbstractController
{
    public function __construct(...QueryBusDispatcher $queryBus)

    public function searchEmployee(Request $request)
    {
        //call form, request etc...

        $searchQuery = new SearchEmployee(...);

       $employees = $this->queryBus->dispatch($searchQuery);

       ...
    }
}


```


