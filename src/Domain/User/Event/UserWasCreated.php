<?php
declare(strict_types=1);

namespace App\Domain\User\Event;


use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Credentials;
use App\Domain\User\ValueObject\HashedPassword;
use Assert\Assertion;
use Broadway\Serializer\Serializable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class UserWasCreated implements Serializable
{
    /** @var UuidInterface */
    private $uuid;

    /** @var Credentials */
    private $credentials;

    public function __construct(UuidInterface $uuid, Credentials $credentials)
    {
        $this->uuid = $uuid;
        $this->credentials = $credentials;
    }

    public function credentials(): Credentials
    {
        return $this->credentials;
    }

    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }

    public static function deserialize(array $data): self
    {
        Assertion::keyExists($data, 'uuid');
        Assertion::keyExists($data, 'credentials');
        Assertion::keyExists($data['credentials'], 'email');
        Assertion::keyExists($data['credentials'], 'password');

        return new self(
            Uuid::fromString($data['uuid']),
            new Credentials(
                Email::fromString($data['credentials']['email']),
                HashedPassword::fromHash($data['credentials']['password'])
            )
        );
    }

    public function serialize(): array
    {
        return [
            'uuid' => $this->uuid->toString(),
            'credentials' => [
                'email' => $this->credentials->email()->toString(),
                'password' => $this->credentials->password()->toString()
            ]
        ];
    }
}