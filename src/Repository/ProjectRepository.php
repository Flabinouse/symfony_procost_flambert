<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    private $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Project::class);
        $this->em = $em;
    }

    public function countInProgressProject(): int
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->where('p.deliveryDate IS NULL')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function countFinishedProject(): int
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->where('p.deliveryDate IS NOT NULL')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function findFiveProjByDate(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.deliveryDate', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    public function sumDailyCostEmployee(int $id): array
    {
        $query = $this->em->createQuery(
            'SELECT em.firstName, em.lastName, sum(prod.nbDays) as nbDays, em.dailyCost as dailyCost
            FROM App\Entity\Employee em, App\Entity\Production prod, App\Entity\Project pjr
            WHERE em.id = prod.employee
            AND prod.project = pjr.id
            AND pjr.id = :id
            GROUP BY em.id'
        )->setParameter('id', $id);

        return $query->getResult();
    }
}
