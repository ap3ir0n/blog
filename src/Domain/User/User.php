<?php
/**
 * Created by PhpStorm.
 * User: patri
 * Date: 09/06/2018
 * Time: 16:45
 */

namespace App\Domain\User;


use Ramsey\Uuid\UuidInterface;

final class User
{
    /** @var UuidInterface */
    private $uuid;

    /** @var Email */
    private $email;

    /** @var HashedPassword */
    private $hashedPassword;
}