<?php
declare(strict_types=1);


namespace App\Application\Command\User;


use App\Application\Command\CommandHandlerInterface;
use App\Domain\User\InvalidCredentialsException;
use App\Domain\User\UserCollectionInterface;
use App\Domain\User\UserRepositoryInterface;

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