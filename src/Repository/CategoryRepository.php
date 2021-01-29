<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{
    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        parent::__construct($registry, Category::class);
    }

    public function getAllCategory(): array
    {
        return parent::findAll();
    }

    public function getOneCategory(int $categoryId): object
    {
        return parent::find($categoryId);
    }

    public function setCreateCategory(Category $category): object
    {
        $category->setCreateAtValue();
        $category->setUpdateAtValue();
        $category->setIsPublished();
        $this->manager->persist($category);
        $this->manager->flush();
        return $category;
    }

    public function setUpdateCategory(Category $category): object
    {
        $category->setUpdateAtValue();
        $this->manager->flush();
        return $category;
    }

    public function setDeleteCategory(Category $category)
    {
        $this->manager->remove($category);
        $this->manager->flush();
    }
    // /**
    //  * @return Category[] Returns an array of Category objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Category
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
