<?php


namespace App\Repository;


use App\Entity\Product;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ProductRepositoryInterface
{
    /**
     * @return array
     */
    public function getAllProduct(): array; //@return array

    /**
     * @param int $productId
     * @return Product
     */
    public function getOneProduct(int $productId): object;

    /**
     * @param Product $product
     * @param UploadedFile $file
     * @return Product
     */
    public function setCreateProduct(Product $product, UploadedFile $file): object;

    /**
     * @param Product $product
     * @param UploadedFile $file
     * @return Product
     */
    public function setUpdateProduct(Product $product,UploadedFile $file): object;

    /**
     * @param Product $product
     */
    public function setDeleteProduct(Product $product);
}