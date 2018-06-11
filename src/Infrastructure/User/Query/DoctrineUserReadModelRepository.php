<?php
declare(strict_types=1);


namespace App\Infrastructure\User\Query;


use App\Domain\User\Email;
use App\Domain\User\User;
use App\Domain\User\UserCollectionInterface;
use App\Infrastructure\Share\Query\Repository\DoctrineRepository;
use Ramsey\Uuid\UuidInterface;

final class DoctrineUserReadModelRepository extends DoctrineRepository implements UserCollectionInterface
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
}