<?php
declare(strict_types=1);


namespace App\Application\Command\User\SignIn;


use App\Domain\User\ValueObject\Email;

final class SignInCommand
{
    /** @var Email */
    private $email;

    /** @var string */
    private $plainPassword;

    public function __construct(string $email, string $plainPassword)
    {
        $this->email = Email::fromString($email);
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function plainPassword(): string
    {
        return $this->plainPassword;
    }

}