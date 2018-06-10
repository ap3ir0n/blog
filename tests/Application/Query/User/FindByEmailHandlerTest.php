<?php
declare(strict_types=1);

/**
 * Date: 10/06/2018
 */

namespace App\Tests\Application\Query\User;

use App\Application\Query\User\FindByEmailHandler;
use PHPUnit\Framework\TestCase;

class FindByEmailHandlerTest extends TestCase
{
    /**
     * @test
     *
     * @group integration
     */
    public function query_command_integration()
    {
        $email = $this->createUserRead();

        $this->fireTerminateEvent();

        /** @var Item $item */
        $item = $this->ask(new FindByEmailQuery($email));
        /** @var UserView $userRead */
        $userRead = $item->readModel;

        self::assertInstanceOf(Item::class, $item);
        self::assertInstanceOf(UserView::class, $userRead);
        self::assertEquals($email, $userRead->credentials->email);
    }

    private function createUserRead(): string
    {
        $uuid = Uuid::uuid4()->toString();
        $email = 'lol@lol.com';

        $this->handle(new SignUpCommand($uuid, $email, 'password'));

        return $email;
    }
}
