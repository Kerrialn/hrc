<?php

namespace App\Repository;

use App\Entity\Experience;
use App\Entity\Resume;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Experience|null find($id, $lockMode = null, $lockVersion = null)
 * @method Experience|null findOneBy(array $criteria, array $orderBy = null)
 * @method Experience[]    findAll()
 * @method Experience[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExperienceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Experience::class);
    }

    public function create(Experience $experienceData, Resume $resume)
    {
        $experience = new Experience();
        $experience->setTitle($experienceData->getTitle());
        $experience->setCompany($experienceData->getCompany());
        $experience->setStartedAt($experienceData->getStartedAt());
        $experience->setCompletedAt($experienceData->getCompletedAt());
        $experience->setResume($resume);
        $this->save($experience);
    }

    public function update(Experience $experience)
    {
        $this->save($experience);
    }

    public function save(Experience $experience)
    {
        $this->_em->persist($experience);
        $this->_em->flush();
    }

    // /**
    //  * @return Experience[] Returns an array of Experience objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Experience
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}