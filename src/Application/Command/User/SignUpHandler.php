<?php
declare(strict_types=1);


namespace App\Application\Command\User;


use App\Application\Command\CommandHandlerInterface;
use App\Domain\User\UserFactory;
use App\Domain\User\UserRepositoryInterface;

final class SignUpHandler implements CommandHandlerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var UserFactory
     */
    private $userFactory;

    /**
     * SignUpHandler constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserFactory $userFactory
     */
    public function __construct(UserRepositoryInterface $userRepository, UserFactory $userFactory)
    {
        $this->userRepository = $userRepository;
        $this->userFactory = $userFactory;
    }

    public function __invoke(SignUpCommand $command): void
    {
        $user = $this->userFactory->register(
            $command->uuid(),
            $command->credentials()
        );

        $this->userRepository->store($user);
    }

}