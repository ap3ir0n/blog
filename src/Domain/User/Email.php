<?php
/**
 * Created by PhpStorm.
 * User: patri
 * Date: 09/06/2018
 * Time: 16:49
 */

namespace App\Domain\User;


use Assert\Assertion;

final class Email
{
    /** @var string */
    private $email;

    private function __construct(string $email)
    {
        Assertion::email($email, 'Not a valid email');

        $this->email = $email;
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public static function fromString(string $email): self
    {
        return new static($email);
    }

    public function toString(): string
    {
        return $this->email;
    }

}