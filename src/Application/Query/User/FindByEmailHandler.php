<?php
declare(strict_types=1);

namespace App\Application\Query\User;


use App\Application\Query\Item;
use App\Application\Query\QueryHandlerInterface;
use App\Domain\User\UserReadModelRepositoryInterface;

final class FindByEmailHandler implements QueryHandlerInterface
{
    /** @var UserReadModelRepositoryInterface */
    private $repository;

    /**
     * FindByEmailHandler constructor.
     * @param UserReadModelRepositoryInterface $repository
     */
    public function __construct(UserReadModelRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FindByEmailQuery $query): Item
    {
        return new Item(
            $this->repository->oneByEmail($query->email())
        );
    }
}