<?php
declare(strict_types=1);

/**
 * Date: 09/06/2018
 */

namespace App\Domain\User\Event;


use App\Domain\User\ValueObject\Email;
use Assert\Assertion;
use Broadway\Serializer\Serializable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class UserSignedIn implements Serializable
{
    /** @var UuidInterface */
    private $uuid;

    /** @var Email */
    private $email;

    /**
     * UserSignedIn constructor.
     * @param UuidInterface $uuid
     * @param Email $email
     */
    public function __construct(UuidInterface $uuid, Email $email)
    {
        $this->uuid = $uuid;
        $this->email = $email;
    }

    /**
     * @return UuidInterface
     */
    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

    public static function deserialize(array $data)
    {
        Assertion::keyExists($data, 'uuid');
        Assertion::keyExists($data, 'email');

        return new static(
            Uuid::fromString($data['uuid']),
            Email::fromString($data['email'])
        );
    }

    public function serialize(): array
    {
        return [
            'uuid' => $this->uuid->toString(),
            'email' => $this->email->toString()
        ];
    }
}