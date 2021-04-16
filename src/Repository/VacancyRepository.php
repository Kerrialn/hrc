<?php

namespace App\Repository;

use App\Entity\Resume;
use App\Entity\User;
use App\Entity\Vacancy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Migrations\Query\Query;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @method Vacancy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vacancy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vacancy[]    findAll()
 * @method Vacancy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VacancyRepository extends ServiceEntityRepository
{
    private User $user;

    public function __construct(
        ManagerRegistry $registry,
        private Security $security,
        private PairRepository $pairRepository
    ) {
        $this->user = $this->security->getUser();
        parent::__construct($registry, Vacancy::class);
    }

    public function getAllUniquePositions()
    {
        $qb = $this->createQueryBuilder('vacancy');
        $qb->select('vacancy.position')->distinct()
            ->where('vacancy.position IS NOT NULL');

        $result = $qb->getQuery()->getArrayResult();
        return array_column($result, 'position');
    }

    public function findUnpairedVacancyByUserResume(?Resume $resume): ?array
    {
        if (!$resume) {
            return null;
        }

        $qb =  $this->createQueryBuilder('vacancy');
        $qb->join('vacancy.category', 'category');

        $qb->where('category.id = :category')->setParameter('category', $resume->getCategory()->getId());

        $qb->andWhere($qb->expr()->between('vacancy.yearsExperience', ':min', ':max'))
            ->setParameter('min', $resume->getYearsExperience() - 1)
            ->setParameter('max', $resume->getYearsExperience() + 1);

        $qb->leftJoin('vacancy.pairs', 'p');
        $qb->leftJoin('p.candidate', 'c', Join::WITH, 'c.id = :user')
            ->having('COUNT(c) = 0')
            ->groupby('vacancy')
            ->setParameter('user', $this->user->getId());

        $vacancies = $qb
            ->getQuery()
            ->getResult();


        $result = [
            'vacancy' => $vacancies[0] ?? null,
            'count' => count($vacancies)
        ];

        return $result;
    }
}
