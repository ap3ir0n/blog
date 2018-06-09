<?php
declare(strict_types=1);

/**
 * Date: 09/06/2018
 */

namespace App\Domain\User;


use Ramsey\Uuid\UuidInterface;

interface UserCollectionInterface
{
    public function existsEmail(Email $email): ?UuidInterface;
}