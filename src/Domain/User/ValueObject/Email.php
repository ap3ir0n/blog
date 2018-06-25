<?php
declare(strict_types=1);

namespace App\Domain\User\ValueObject;


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