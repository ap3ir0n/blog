<?php
declare(strict_types=1);


namespace App\Infrastructure\Share\Query\Repository;


use App\Infrastructure\Share\Query\Exception\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

abstract class DoctrineRepository
{
    /** @var string */
    protected $class;

    /** @var EntityRepository */
    protected $repository;

    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * DoctrineRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->setRepository($this->class);
    }

    private function setRepository(string $model): void
    {
        $this->repository = $this->entityManager->getRepository($model);
    }

    public function register($model): void
    {
        $this->entityManager->persist($model);
        $this->apply();
    }

    public function apply(): void
    {
        $this->entityManager->flush();
    }

    protected function oneOrException(QueryBuilder $queryBuilder)
    {
        $model = $queryBuilder
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if (null === $model) {
            throw new NotFoundException();
        }

        return $model;
    }

}