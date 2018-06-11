<?php
declare(strict_types=1);


namespace App\Application\Command\User;


use App\Domain\User\Credentials;
use App\Domain\User\Email;
use App\Domain\User\HashedPassword;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class SignUpCommand
{
    /** @var UuidInterface */
    private $uuid;

    /** @var Credentials */
    private $credentials;

    public function __construct(string $uuid, string $email, string $plainPassword)
    {
        $this->uuid = Uuid::fromString($uuid);
        $this->credentials = new Credentials(
            Email::fromString($email),
            HashedPassword::encode($plainPassword)
        );
    }

    /**
     * @return UuidInterface
     */
    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @return Credentials
     */
    public function credentials(): Credentials
    {
        return $this->credentials;
    }

}