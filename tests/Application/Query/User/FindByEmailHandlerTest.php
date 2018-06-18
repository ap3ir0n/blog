<?php
declare(strict_types=1);

/**
 * Date: 10/06/2018
 */

namespace App\Tests\Application\Query\User;

use App\Application\Command\User\SignUpCommand;
use App\Application\Query\Item;
use App\Application\Query\User\FindByEmailHandler;
use App\Application\Query\User\FindByEmailQuery;
use App\Infrastructure\User\Query\UserView;
use App\Tests\Application\ApplicationTestCase;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class FindByEmailHandlerTest extends ApplicationTestCase
{
    /**
     * @test
     *
     * @group integration
     */
    public function queryCommandIntegration()
    {
        $email = $this->createUserRead();

        /** @var Item $item */
        $item = $this->ask(new FindByEmailQuery($email));

        /** @var UserView $userRead */
        $userRead = $item->readModel();

        self::assertInstanceOf(Item::class, $item);
        self::assertInstanceOf(UserView::class, $userRead);
        self::assertEquals($email, $userRead->credentials()->email());
    }

    private function createUserRead(): string
    {
        $uuid = Uuid::uuid4()->toString();
        $email = 'p.fazzi@test.com';

        $this->handle(new SignUpCommand(
            $uuid,
            $email,
            'verySecretPassword'
        ));

        return $email;
    }
}
