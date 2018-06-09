<?php
declare(strict_types=1);

/**
 * Date: 09/06/2018
 */

namespace App\Tests\Domain\User;

use App\Domain\User\Credentials;
use App\Domain\User\Email;
use App\Domain\User\EmailAlreadyExistException;
use App\Domain\User\HashedPassword;
use App\Domain\User\UserCollectionInterface;
use App\Domain\User\UserFactory;
use App\Domain\User\UserWasCreated;
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
     * @expectedException \App\Domain\User\EmailAlreadyExistException
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
