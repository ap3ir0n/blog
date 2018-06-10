<?php
declare(strict_types=1);

namespace App\Infrastructure\User\Query;


use App\Domain\User\Credentials;
use App\Domain\User\Email;
use App\Domain\User\HashedPassword;
use Assert\Assertion;
use Broadway\ReadModel\SerializableReadModel;
use Broadway\Serializer\Serializable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class UserView implements SerializableReadModel
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

    public static function fromSerializable(Serializable $serializable): self
    {
        return self::deserialize($serializable->serialize());
    }

    public static function deserialize(array $data)
    {
        Assertion::keyExists($data, 'uuid');
        Assertion::keyExists($data, 'credentials');
        Assertion::keyExists($data['credentials'], 'email');

        return new self(
            Uuid::fromString($data['uuid']),
            new Credentials(
                Email::fromString($data['credentials']['email']),
                HashedPassword::fromHash($data['credentials']['password'] ?? '')
            )
        );
    }

    public function serialize(): array
    {
        return [
            'uuid'        => $this->getId(),
            'credentials' => [
                'email' => (string) $this->credentials->email(),
            ],
        ];
    }

    public function getId(): string
    {
        return $this->uuid->toString();
    }


}