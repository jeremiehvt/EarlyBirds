<?php

namespace App\Domain\Repository;

use App\Domain\Models\Level;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Level|null find($id, $lockMode = null, $lockVersion = null)
 * @method Level|null findOneBy(array $criteria, array $orderBy = null)
 * @method Level[]    findAll()
 * @method Level[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LevelRepository extends ServiceEntityRepository
{
    /**
     * LevelRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Level::class);
    }

    /**
     * @param Level $level
     *
     * @return bool
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Level $level): bool
    {
        $this->getEntityManager()->persist($level);
        $this->getEntityManager()->flush();

        return true;
    }

    /**
     * @param Level $level
     *
     * @return bool
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(Level $level): bool
    {
        $this->getEntityManager()->remove($level);
        $this->getEntityManager()->flush();

        return true;
    }

    /**
     * @return mixed
     */
    public function findAllOrderByPrice()
    {
        return $this->createQueryBuilder('level')
            ->orderBy('level.points')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Level[] Returns an array of Level objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Level
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
