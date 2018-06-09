<?php
declare(strict_types=1);

namespace App\Domain\User;


use Assert\Assertion;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Ramsey\Uuid\UuidInterface;

final class User extends EventSourcedAggregateRoot
{
    /** @var UuidInterface */
    private $uuid;

    /** @var Email */
    private $email;

    /** @var HashedPassword */
    private $hashedPassword;

    public static function create(UuidInterface $uuid, Credentials $credentials): self
    {
        $user = new static();

        $user->apply(new UserWasCreated($uuid, $credentials));

        return $user;
    }

    public function uuid(): string
    {
        return $this->uuid->toString();
    }

    public function email(): string
    {
        return $this->email->toString();
    }

    public function changeEmail(Email $email): void
    {
        $this->apply(new UserEmailChanged($this->uuid, $email));
    }

    public function getAggregateRootId(): string
    {
        return $this->uuid->toString();
    }

    public function signIn($plainPassword): void
    {
        if (!$this->hashedPassword->match($plainPassword)) {
            throw new InvalidCredentialsException();
        }

        $this->apply(new UserSignedIn(
            $this->uuid,
            $this->email
        ));
    }

    protected function applyUserWasCreated(UserWasCreated $event): void
    {
        $this->uuid = $event->uuid();
        $this->setEmail($event->credentials()->email());
        $this->setHashedPassword($event->credentials()->password());
    }

    private function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    private function setHashedPassword(HashedPassword $hashedPassword): void
    {
        $this->hashedPassword = $hashedPassword;
    }

    protected function applyUserEmailChanged(UserEmailChanged $event): void
    {
        Assertion::notEq(
            $this->email->toString(),
            $event->email()->toString(),
            'New e-mail can not be equal to the previous'
        );

        $this->setEmail($event->email());
    }

}