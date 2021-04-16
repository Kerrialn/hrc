<?php

namespace App\Repository;

use App\Entity\Pair;
use App\Entity\Resume;
use App\Entity\User;
use App\Entity\Vacancy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pair|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pair|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pair[]    findAll()
 * @method Pair[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PairRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pair::class);
    }

    public function create(User $user, Vacancy $vacancy, bool $isliked, Resume $resume)
    {
        $pair = new Pair();
        $pair->setCandidate($user);
        $pair->setVacancy($vacancy);
        $pair->setIsPositionLiked($isliked);
        $pair->setResume($resume);

        $this->save($pair);
    }


    public function getCandidateMatches(User $user)
    {

        $qb = $this->createQueryBuilder('p');
        $qb->where('p.candidate = :user')->setParameter('user', $user->getId());
        $qb->andWhere('p.isPositionLiked = true');
        $qb->andWhere('p.isCandidateLiked = true');
        $qb->orderBy('p.createdAt', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function save(Pair $pair)
    {
        $this->_em->persist($pair);
        $this->_em->flush();
    }
    // /**
    //  * @return Pair[] Returns an array of Pair objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pair
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
