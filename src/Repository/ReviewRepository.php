<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository implements ReviewRepositoryInterface
{
    /*public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    } */

    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        parent::__construct($registry, Review::class);
    }

    public function getAllReview(): array
    {
        return parent::findAll();
    }

    public function getOneReview(int $reviewId): object
    {
        return parent::find($reviewId);
    }

    public function setCreateReview(Review $review): object
    {
        $review->setCreateAtValue();
        $review->setUpdateAtValue();
        $review->setIsPublished();
        //$review->setContent('content');
        //$review->setProduct();
        $this->manager->persist($review);
        $this->manager->flush();
        return $review;
    }

    public function setUpdateCategory(Review $review): object
    {
        $review->setUpdateAtValue();
        $this->manager->flush();
        return $review;
    }

    public function setDeleteReview(Review $review)
    {
        $this->manager->remove($review);
        $this->manager->flush();
    }

    // /**
    //  * @return Review[] Returns an array of Review objects
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
    public function findOneBySomeField($value): ?Review
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
