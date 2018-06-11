<?php
declare(strict_types=1);


namespace App\Application\Command\User;


use App\Domain\User\Email;

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
}