<?php
declare(strict_types=1);


namespace App\Application\Command\User\SignUp;


use App\Application\Command\CommandHandlerInterface;
use App\Application\Command\User\SignUp\SignUpCommand;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Repository\UserRepositoryInterface;

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