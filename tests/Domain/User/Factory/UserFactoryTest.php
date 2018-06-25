<?php
declare(strict_types=1);

/**
 * Date: 09/06/2018
 */

namespace App\Tests\Domain\User\Factory;

use App\Domain\User\ValueObject\Credentials;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\Exception\EmailAlreadyExistException;
use App\Domain\User\ValueObject\HashedPassword;
use App\Domain\User\Repository\UserCollectionInterface;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Event\UserWasCreated;
use Broadway\Domain\DomainMessage;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserFactoryTest extends TestCase
{
    /**
     * @test
     * @group unit
     */
    public function givenCorrectCredentialItShouldRegisterANewUser()
    {
        $userCollection = self::getMockBuilder(UserCollectionInterface::class)->getMock();

        $userFactory = new UserFactory($userCollection);

        $user = $userFactory->register(
            Uuid::uuid4(),
            new Credentials(
                Email::fromString('p.fazzi@test.com'),
                HashedPassword::encode('verySecretPassword')
            )
        );

        self::assertNotNull($user->uuid());
        self::assertEquals('p.fazzi@test.com', $user->email());
    }

    /**
     * @test
     * @group unit
     * @expectedException \App\Domain\User\Exception\EmailAlreadyExistException
     */
    public function givenAnAlreadyRegisteredEmailItShouldThrowAnException()
    {
        $userCollection = self::getMockBuilder(UserCollectionInterface::class)->getMock();

        $userCollection
            ->method('existsEmail')
            ->willReturn(Uuid::uuid4());

        $userFactory = new UserFactory($userCollection);

        $user = $userFactory->register(
            Uuid::uuid4(),
            new Credentials(
                Email::fromString('p.fazzi@test.com'),
                HashedPassword::encode('verySecretPassword')
            )
        );


    }
}
