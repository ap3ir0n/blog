<?php
/**
 * Created by PhpStorm.
 * User: patri
 * Date: 09/06/2018
 * Time: 16:46
 */

namespace App\Tests\Domain\User;

use App\Domain\User\Credentials;
use App\Domain\User\Email;
use App\Domain\User\HashedPassword;
use App\Domain\User\InvalidCredentialsException;
use App\Domain\User\User;
use App\Domain\User\UserEmailChanged;
use App\Domain\User\UserSignedIn;
use App\Domain\User\UserWasCreated;
use Broadway\Domain\DomainMessage;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserTest extends TestCase
{
    /**
     * @test
     * @group unit
     */
    public function givenAValidEmailItShouldCreateAUserInstance()
    {
        $user = User::create(
            Uuid::uuid4(),
            new Credentials(
                Email::fromString('p.fazzi@test.com'),
                HashedPassword::encode('verySecretPassword')
            )
        );

        self::assertNotNull($user->uuid());
        self::assertEquals('p.fazzi@test.com', $user->email());

        $events = $user->getUncommittedEvents();
        self::assertCount(1, $events->getIterator());

        /** @var DomainMessage $event */
        $event = $events->getIterator()->current();
        self::assertInstanceOf(UserWasCreated::class, $event->getPayload());
    }

    /**
     * @test
     * @group unit
     */
    public function givenANewEmailItShouldChangeIfNotEqToPrevEmail()
    {
        $user = User::create(
            Uuid::uuid4(),
            new Credentials(
                Email::fromString('p.fazzi@test.com'),
                HashedPassword::encode('verySecretPassword')
            )
        );

        $user->changeEmail(Email::fromString('patrick.fazzi@test.com'));

        self::assertEquals($user->email(), 'patrick.fazzi@test.com');

        $events = $user->getUncommittedEvents();
        self::assertCount(2, $events->getIterator());

        /** @var DomainMessage $event */
        $event = $events->getIterator()->offsetGet(1);
        self::assertInstanceOf(UserEmailChanged::class, $event->getPayload());
    }

    /**
     * @test
     * @group unit
     * @expectedException \InvalidArgumentException
     */
    public function givenTheSameEmailItShouldThrowAnException()
    {
        $user = User::create(
            Uuid::uuid4(),
            new Credentials(
                Email::fromString('p.fazzi@test.com'),
                HashedPassword::encode('verySecretPassword')
            )
        );

        $user->changeEmail(Email::fromString('p.fazzi@test.com'));
    }

    /**
     * @test
     * @group unit
     */
    public function givenCorrectPasswordItShouldSignIn()
    {
        $user = User::create(
            Uuid::uuid4(),
            new Credentials(
                Email::fromString('p.fazzi@test.com'),
                HashedPassword::encode('verySecretPassword')
            )
        );

        $user->signIn('verySecretPassword');

        $events = $user->getUncommittedEvents();
        self::assertCount(2, $events->getIterator());

        /** @var DomainMessage $event */
        $event = $events->getIterator()->offsetGet(1);
        self::assertInstanceOf(UserSignedIn::class, $event->getPayload());
    }

    /**
     * @test
     * @group unit
     * @expectedException \App\Domain\User\InvalidCredentialsException
     */
    public function givenWrongPasswordItShouldNotSignIn()
    {
        $user = User::create(
            Uuid::uuid4(),
            new Credentials(
                Email::fromString('p.fazzi@test.com'),
                HashedPassword::encode('verySecretPassword')
            )
        );

        $user->signIn('wrongPassword');
    }
}
