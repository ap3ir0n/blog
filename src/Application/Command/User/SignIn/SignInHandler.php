<?php
declare(strict_types=1);


namespace App\Application\Command\User\SignIn;


use App\Application\Command\CommandHandlerInterface;
use App\Application\Command\User\SignIn\SignInCommand;
use App\Domain\User\Exception\InvalidCredentialsException;
use App\Domain\User\Repository\UserCollectionInterface;
use App\Domain\User\Repository\UserRepositoryInterface;

final class SignInHandler implements CommandHandlerInterface
{
    /** @var UserRepositoryInterface */
    private $userRepository;

    /** @var UserCollectionInterface */
    private $userCollection;

    /**
     * SignInHandler constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserCollectionInterface $userCollection
     */
    public function __construct(UserRepositoryInterface $userRepository, UserCollectionInterface $userCollection)
    {
        $this->userRepository = $userRepository;
        $this->userCollection = $userCollection;
    }

    /**
     * @param SignInCommand $command
     * @throws InvalidCredentialsException
     */
    public function __invoke(SignInCommand $command): void
    {
        $uuid = $this->userCollection->existsEmail($command->email());
        if (is_null($uuid)) {
            throw new InvalidCredentialsException();
        }

        $user = $this->userRepository->get($uuid);

        $user->signIn($command->plainPassword());

        $this->userRepository->store($user);
    }

}