<?php
declare(strict_types=1);

namespace App\Domain\User\ValueObject;


use Assert\Assertion;

final class HashedPassword
{
    /** @var string */
    private $hashedPassword;

    public const COST = 12;

    /**
     * HashedPassword constructor.
     * @param string $hashedPassword
     */
    private function __construct(string $hashedPassword)
    {
        $this->hashedPassword = $hashedPassword;
    }

    public function match($plainPassword): bool
    {
        return password_verify($plainPassword, $this->hashedPassword);
    }

    public static function fromHash(string $hashedPassword): self
    {
        return new static($hashedPassword);
    }

    public static function encode(string $plainPassword): self
    {
        $hash = self::hash($plainPassword);

        return self::fromHash($hash);
    }

    private static function hash(string $plainPassword): string
    {
        self::validate($plainPassword);

        return password_hash($plainPassword, PASSWORD_BCRYPT, ['cost' => self::COST]);
    }

    private static function validate(string $plainPassword): void
    {
        Assertion::minLength($plainPassword, 6, 'Password must have at least 6 characters');
    }

    public function __toString()
    {
        return $this->hashedPassword;
    }

    public function toString(): string
    {
        return (string) $this;
    }
}