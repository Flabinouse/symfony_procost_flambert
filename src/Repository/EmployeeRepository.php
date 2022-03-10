<?php

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    private $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Employee::class);
        $this->em = $em;
    }

    public function findTopEmployees(): array
    {
        $query = $this->em->createQuery(
            'SELECT em.firstName, em.lastName, em.hireDate, (em.dailyCost * sum(prod.nbDays)) as totalCost
            FROM App\Entity\Employee em, App\Entity\Production prod, App\Entity\Project pjr
            WHERE em.id = prod.employee
            AND prod.project = pjr.id
            GROUP BY em.id
            ORDER BY totalCost DESC'
        );

        return $query->getResult();
    }

//     SELECT em.first_name, em.last_name, em.hire_date, (em.daily_cost * sum(prod.nb_days)) as totatCost
// FROM employee em, production prod, project pjr
// WHERE em.id = prod.employee_id
// AND prod.project_id = pjr.id
// GROUP BY em.id;
}
