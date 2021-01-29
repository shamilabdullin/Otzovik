<?php


namespace App\Controller\Admin;


use App\Controller\Main\BaseController;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ProductRepositoryInterface;
use App\Repository\ReviewRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminReviewController extends BaseController
{
    private $productRepository;
    private $reviewRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository, ProductRepositoryInterface $productRepository){
        $this->reviewRepository = $reviewRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("admin/category/product/review/", name="admin_review")
     */

    public function index(){
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Отзывы';
        $forRender['review'] = $this->reviewRepository->getAllReview();//$forRender['review'] = 'Test';
        //$forRender['product'] = $this->productRepository->getOneProduct();
        //$forRender['check_category'] = $this->categoryRepository->getAllCategory();
        return $this->render('admin/review/index.html.twig', $forRender);
    }

    /**
     * @Route ("admin/category/product/review/create", name="admin_review_create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(Request $request){
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->reviewRepository->setCreateReview($review);
            $this->addFlash('success','Отзыв добавлен');
            return $this->redirectToRoute('admin_review');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Создание отзыва';
        $forRender['form'] = $form->createView(); //$form['form']
        return $this->render('admin/review/form.html.twig', $forRender);
    }

    /**
     * @Route("admin/review/update/{id}", name="admin_review_update")
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function update(int $id, Request $request)
    {

        $review = $this->reviewRepository->getOneReview($id);
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            if ($form->get('save')->isClicked()){
                $this->reviewRepository->setUpdateCategory($review);
                $this->addFlash('success', 'Отзыв обновлена');
            }
            if($form->get('delete')->isClicked()){
                $this->reviewRepository->setDeleteReview($review);
                $this->addFlash('success', 'Отзыв удален');
            }

            return $this->redirectToRoute('admin_review');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Редактирование отзыва';
        $forRender['form'] = $form->createView(); //$form['form']
        return $this->render('admin/review/form.html.twig', $forRender);
    }
}