<?php


namespace App\Controller\Admin;


use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminProductController extends AdminBaseController
{
    private $categoryRepository;

    private $productRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository, ProductRepositoryInterface $productRepository){
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/admin/product", name="admin_product")
     */
    public function index()
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Товары';
        $forRender['product'] = $this->productRepository->getAllProduct();
        $forRender['check_category'] = $this->categoryRepository->getAllCategory();
        return $this->render('admin/product/index.html.twig', $forRender);
    }

    /**
     * @Route("/admin/product/create", name="admin_product_create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file = $form->get('image')->getData();
            $this->productRepository->setCreateProduct($product, $file);
            $this->addFlash('success', 'Товар добавлен');
            return $this->redirectToRoute('admin_product');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Создание товара';
        $forRender['form'] = $form->createView(); //$form['form']
        return $this->render('admin/product/form.html.twig', $forRender);
    }

    /**
     * @Route("admin/product/update/{id}", name="admin_product_update")
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function update(int $id, Request $request)
    {
        $product = $this->productRepository->getOneProduct($id);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            if ($form->get('save')->isClicked()){
                $file = $form->get('image')->getData();
                $this->productRepository->setUpdateProduct($product, $file);
                $this->addFlash('success', 'Товар обновлен');
            }
            if($form->get('delete')->isClicked()){
                $this->productRepository->setDeleteProduct($product);
                $this->addFlash('success', 'Товар удален');
            }
            return $this->redirectToRoute('admin_product');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Редактирование товара';
        $forRender['form'] = $form->createView(); //$form['form']
        return $this->render('admin/product/form.html.twig', $forRender);
    }

}