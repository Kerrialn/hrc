<?php

namespace App\Repository;

use App\Entity\Qualification;
use App\Entity\Resume;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Qualification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Qualification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Qualification[]    findAll()
 * @method Qualification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QualificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Qualification::class);
    }

    public function create(Qualification $qualificationData, Resume $resume)
    {
        $qualification = new Qualification();
        $qualification->setTitle($qualificationData->getTitle());
        $qualification->setCompletedAt($qualificationData->getCompletedAt());
        $qualification->setIssuer($qualificationData->getIssuer());
        $qualification->setResume($resume);

        $this->save($qualification);
    }

    public function save(Qualification $qualification)
    {
        $this->_em->persist($qualification);
        $this->_em->flush();
    }

    // /**
    //  * @return Qualification[] Returns an array of Qualification objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Qualification
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
