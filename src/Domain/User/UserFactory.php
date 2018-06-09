<?php
declare(strict_types=1);

/**
 * Date: 09/06/2018
 */

namespace App\Domain\User;


use Ramsey\Uuid\UuidInterface;

final class UserFactory
{
    /**
     * @var UserCollectionInterface
     */
    private $userCollection;

    public function __construct(UserCollectionInterface $userCollection)
    {
        $this->userCollection = $userCollection;
    }

    public function register(UuidInterface $uuid, Credentials $credentials): User
    {
        if ($this->userCollection->existsEmail($credentials->email())) {
            throw new EmailAlreadyExistException();
        }

        return User::create($uuid, $credentials);
    }
}