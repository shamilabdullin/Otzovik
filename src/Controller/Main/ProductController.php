<?php


namespace App\Controller\Main;


use App\Repository\CategoryRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends BaseController
{
    private $productRepository;
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository, ProductRepositoryInterface $productRepository){
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/category/{id}", name="product")
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function index(int $id){
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Товары';
        $forRender['product'] = $this->productRepository->getAllProduct();
        $forRender['category'] = $this->categoryRepository->getOneCategory($id);
        return $this->render('main/product/index.html.twig', $forRender);
    }
}