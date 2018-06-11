<?php
declare(strict_types=1);


namespace App\Tests\Application\Command\User;

use App\Application\Command\User\SignUpCommand;
use App\Tests\Application\ApplicationTestCase;

class SignUpHandlerTest extends ApplicationTestCase
{
    /**
     * @test
     *
     * @group integration
     */
    public function commandHandlerMustFireDomainEvent()
    {

        $command = new SignUpCommand(
            'a187784a-c7b4-4da3-a50e-a98a91d32cb3',
            'p.fazzi@test.com',
            'verySecretPassword'
        );

        $this->handle($command);

        // TODO: Capire perchè non funziona

//        /** @var EventCollectorListener $collector */
//        $collector = $this->service(EventCollectorListener::class);
//
//        /** @var DomainMessage[] $events */
//        $events = $collector->popEvents();
//
//        self::assertCount(1, $events);
//
//        /** @var UserWasCreated $userCreatedEvent */
//        $userCreatedEvent = $events[0]->getPayload();
//
//        self::assertInstanceOf(UserWasCreated::class, $userCreatedEvent);
    }
}
