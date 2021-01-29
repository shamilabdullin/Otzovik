<?php


namespace App\Controller\Main;


use App\Repository\CategoryRepositoryInterface;
use App\Repository\ProductRepository;
use App\Repository\ProductRepositoryInterface;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends BaseController
{
    private $categoryRepository;
    private $productRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository, ProductRepositoryInterface $productRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/category", name="category")
     */
    public function index()
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Категории товаров';
        $forRender['category'] = $this->categoryRepository->getAllCategory();
        $forRender['product'] = $this->productRepository->getAllProduct();
        return $this->render('main/category/index.html.twig', $forRender);
    }
}