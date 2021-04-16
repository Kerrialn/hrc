<?php

namespace App\Repository;

use App\Entity\Resume;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @method Resume|null find($id, $lockMode = null, $lockVersion = null)
 * @method Resume|null findOneBy(array $criteria, array $orderBy = null)
 * @method Resume[]    findAll()
 * @method Resume[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResumeRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private Security $security
    ) {
        parent::__construct($registry, Resume::class);
    }


    public function create(User $user, Resume $resumeData)
    {
        $resume = new Resume();
        $resume->setName($resumeData->getName());
        $resume->setPosition($resumeData->getPosition());
        $resume->setStatement($resumeData->getStatement());
        $resume->setCategory($resumeData->getCategory());
        $resume->setYearsExperience($resumeData->getYearsExperience());
        $resume->setOwner($user);
        $this->save($resume);
    }


    public function save(Resume $resume)
    {
        $this->_em->persist($resume);
        $this->_em->flush();
    }

    // /**
    //  * @return Resume[] Returns an array of Resume objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Resume
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
