<?php
declare(strict_types=1);


namespace App\Infrastructure\User\Query;


use App\Domain\User\Email;
use App\Domain\User\UserCollectionInterface;
use App\Domain\User\UserReadModelRepositoryInterface;
use App\Infrastructure\Share\Query\Repository\DoctrineRepository;
use Ramsey\Uuid\UuidInterface;

final class DoctrineUserReadModelRepository extends DoctrineRepository implements UserCollectionInterface, UserReadModelRepositoryInterface
{
    protected $class = UserView::class;

    public function existsEmail(Email $email): ?UuidInterface
    {
        $userId = $this->repository
            ->createQueryBuilder('user')
            ->select('user.uuid')
            ->where('user.credentials.email = :email')
            ->setParameter('email', $email->toString())
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $userId['uuid'] ?? null;
    }

    public function oneByUuid(UuidInterface $uuid): UserView
    {
        $qb = $this->repository
            ->createQueryBuilder('user')
            ->select('user')
            ->where('user.uuid = :uuid')
            ->setParameter('uuid', $uuid->getBytes());

        return $this->oneOrException($qb);
    }

    public function oneByEmail(Email $email): UserView
    {
        $qb = $this->repository
            ->createQueryBuilder('user')
            ->select('user')
            ->where('user.credentials.email = :email')
            ->setParameter('email', $email);

        return $this->oneOrException($qb);
    }

    public function add(UserView $userRead): void
    {
        $this->register($userRead);
    }


}