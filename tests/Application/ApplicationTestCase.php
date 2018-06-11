<?php
declare(strict_types=1);


namespace App\Tests\Application;


use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
}