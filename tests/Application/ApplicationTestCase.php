<?php
declare(strict_types=1);


namespace App\Tests\Application;


use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApplicationTestCase extends KernelTestCase
{
    /** @var CommandBus|null */
    private $commandBus;

    /** @var CommandBus|null */
    private $queryBus;

    protected function setUp()
    {
        static::bootKernel();

        $this->commandBus = static::$container->get('tactician.commandbus.command');
        $this->queryBus = static::$container->get('tactician.commandbus.query');
    }

    protected function tearDown()
    {
        $this->commandBus = null;
        $this->queryBus = null;
    }

    protected function ask($query)
    {
        return $this->queryBus->handle($query);
    }

    protected function handle($command): void
    {
        $this->commandBus->handle($command);
    }

    protected function service(string $serviceId)
    {
        return self::$container->get($serviceId);
    }

    protected function fireTerminateEvent(): void
    {
        /** @var EventDispatcherInterface $dispatcher */
        $dispatcher = $this->service('event_dispatcher');

        $dispatcher->dispatch(
            KernelEvents::TERMINATE,
            new PostResponseEvent(
                static::$kernel,
                Request::create('/'),
                Response::create()
            )
        );
    }
}