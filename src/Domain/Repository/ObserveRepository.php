<?php

namespace App\Domain\Repository;

use App\Domain\Models\Observe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Observe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Observe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Observe[]    findAll()
 * @method Observe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObserveRepository extends ServiceEntityRepository
{
    /**
     * ObserveRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Observe::class);
    }

    /**
     * @param Observe $observe
     */
    public function save(Observe $observe): void
    {
        $this->_em->persist($observe);
        $this->_em->flush();
    }

    public function update(): void
    {
        $this->_em->flush();
    }

    /**
     * @param string $userId
     *
     * @return mixed
     */
    public function findMyObservationsByOrderDesc(string $userId)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.author = :author')
            ->setParameter('author', $userId)
            ->orderBy('p.updatedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array
     */
    public function findLastObservation()
    {
        return $this->createQueryBuilder('obs')
            ->leftJoin('obs.validator', 'v')
            ->addSelect('v')
            ->andWhere('v IS NOT NULL')
            ->leftJoin('obs.ref', 'tax')
            ->addSelect('tax')
            ->leftJoin('obs.author', 'auth')
            ->addSelect('auth')
            ->orderBy('obs.createdAt', 'DESC')
            ->setMaxResults(100)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @param string $userId
     * @param        $lat
     * @param        $long
     * @return array
     */
    public function findObservationByLatLong(string $userId, $lat, $long)
    {
        $qb = $this->createQueryBuilder('obs')
            ->andwhere('obs.author = :authorId',
                    'obs.latitude = :lat',
                    'obs.longitude = :long')
            ->setParameters(['authorId'=> $userId,
                                'lat'  => $lat,
                                'long' => $long
                            ])
            ->leftJoin('obs.author', 'usr')
            ->addSelect('usr')
            ->leftJoin('obs.ref','tax')
            ->addSelect('tax')
            ;

        $qr = $qb->getQuery()->getArrayResult();

        return $qr;
    }
  
    /**
     * @return mixed
     */
    public function findNonValidate()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.validator IS NULL')
            ->orderBy('p.updatedAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return mixed
     */
    public function findValidate()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.validator IS NOT NULL')
            ->orderBy('p.updatedAt', 'DESC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return mixed
     */
    public function findValidateLimitTwo()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.validator IS NOT NULL')
            ->orderBy('p.updatedAt', 'DESC')
            ->setMaxResults(2)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Observe $observe
     *
     * @return bool
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(Observe $observe): bool
    {
        $this->getEntityManager()->remove($observe);
        $this->getEntityManager()->flush();

        return true;
    }
}
