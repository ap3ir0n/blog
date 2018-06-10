<?php
declare(strict_types=1);


namespace App\Domain\User;


use App\Infrastructure\User\Query\UserView;
use Ramsey\Uuid\UuidInterface;

interface UserReadModelRepositoryInterface
{
    public function oneByUuid(UuidInterface $uuid): UserView;

    public function oneByEmail(Email $email): UserView;
}