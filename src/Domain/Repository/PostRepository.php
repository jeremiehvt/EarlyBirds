<?php

namespace App\Domain\Repository;

use App\Domain\Models\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }

//    /**
//     * @return Post[] Returns an array of Post objects
//     */
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
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param Post $post
     * @return void
     */
    public function save(Post $post): void
    {
        $this->_em->persist($post);
        $this->_em->flush();
    }

    /**
     * @return void
     */
    public function update(): void
    {
        $this->_em->flush();
    }

    /**
     * @param Post $post
     * @return bool
     */
    public function delete(Post $post): bool
    {
        $this->_em->remove($post);
        $this->_em->flush();

        return true;
    }

    /**
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findLastArticle()
    {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults(1);
        $qr = $qb->getQuery()->getOneOrNullResult();
        return $qr;

    }

    /**
     * @return array
     */
    public function findLastFivePost()
    {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults(6);
        $qr = $qb->getQuery()->getResult();
        return $qr;
    }

    /**
     * @param string $search
     * @return mixed
     */
    public function findBySearch(string $search)
    {
        $qb = $this->createQueryBuilder('p');
            $qr = $qb
            ->where($qb->expr()->like('p.title',':search'))
            ->setParameter('search' , '%'.$search.'%')
                ->leftJoin('p.author','a')
                ->addSelect('a')
                ->leftJoin('p.favouredBy','f')
                ->addSelect('f')
                ->orderBy('p.createdAt','DESC')
            ;
       return $result = $qr->getQuery()->getArrayResult();
    }

    /**
     * @return array
     */
    public function initAll()
    {
        $qb = $this->createQueryBuilder('p');
            $qr = $qb->leftJoin('p.author','a')
                     ->addSelect('a')
                     ->leftJoin('p.favouredBy','f')
                     ->addSelect('f')
                     ->orderBy('p.createdAt','DESC')
        ;

        return $result = $qr->getQuery()->getArrayResult();
    }

    /**
     * @param $search
     * @return array
     */
    public function findByCategory($search)
    {
        $qb = $this->createQueryBuilder('p');
        $qr = $qb->where('p.category = :cat')
            ->setParameter('cat', $search)
            ->leftJoin('p.author','a')
            ->addSelect('a')
            ->leftJoin('p.favouredBy','f')
            ->addSelect('f')
            ->orderBy('p.createdAt','DESC')
        ;

        return $result = $qr->getQuery()->getArrayResult();
    }
}
