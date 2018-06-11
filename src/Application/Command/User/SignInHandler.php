<?php
declare(strict_types=1);


namespace App\Application\Command\User;


use App\Application\Command\CommandHandlerInterface;

final class SignInHandler implements CommandHandlerInterface
{
    public function __invoke(SignInCommand $command): void
    {

    }

}