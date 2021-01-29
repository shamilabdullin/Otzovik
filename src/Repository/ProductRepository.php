<?php

namespace App\Repository;

use App\Entity\Product;
use App\Service\FileManagerServiceInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    private $em;

    private $fm;

    private $manager;

    public function __construct(ManagerRegistry $registry,
                                EntityManagerInterface $manager,
                                FileManagerServiceInterface $fileManagerService)
    {
        $this->manager = $manager;
        $this->em = $manager;
        $this->fm = $fileManagerService;
        parent::__construct($registry, Product::class);
    }

    public function getAllProduct(): array
    {
        return parent::findAll();
    }

    public function getOneProduct($productId): object
    {
        return parent::find($productId);
    }

    /*public function getProductWithCategory(int $categoryId){
        return parent::findBy(array($categoryId => ));
    }*/

    public function setCreateProduct(Product $product, UploadedFile $file): object
    {
        if ($file){
            $fileName = $this->fm->imageProductUpload($file);
            $product->setImage($fileName);
        }
        $product->setCreateAtValue();
        //$product->setUpdateAtValue();
        $product->setIsPublished();
        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }

    public function setUpdateProduct(Product $product, UploadedFile $file): object
    {
        $fileName = $product->getImage();
        if ($file){
            if ($fileName){
                $this->fm->removeProductImage($fileName);
            }
            $fileName = $this->fm->imageProductUpload($file);
            $product->setImage($fileName);
        }
        //$product->setUpdateAtValue();
        $this->em->flush();

        return $product;
    }

    public function setDeleteProduct(Product $product)
    {
        $fileName = $product->getImage();
        if ($fileName){
            $this->fm->removeProductImage($fileName);
        }
        $this->em->remove($product);
        $this->em->flush();
    }
    /*public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }*/

    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
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
