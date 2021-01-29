<?php


namespace App\Controller\Main;


use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ReviewRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends BaseController
{
    private $productRepository;
    private $reviewRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository, ProductRepositoryInterface $productRepository){
        $this->reviewRepository = $reviewRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/category/product/review/{id}", name="all_review")
     * @param $id
     * @return RedirectResponse|Response
     */

    public function index($id){
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Отзывы';
        $forRender['review'] = $this->reviewRepository->getAllReview();//$forRender['review'] = 'Test';
        $forRender['product'] = $this->productRepository->getOneProduct($id);
        return $this->render('main/review/index.html.twig', $forRender);
    }


    /**
     * @Route("/category/product/review/show/{id}", name="review")
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function showReview(int $id){
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Отзыв';
        $forRender['review'] = $this->reviewRepository->getOneReview($id);
        return $this->render('main/review/review.html.twig', $forRender);
    }

    /**
     * @Route ("category/product/review/create/{id}", name="review_create")
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
            return $this->redirectToRoute('all_review', ['id' => 1]);
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Создание отзыва';
        $forRender['form'] = $form->createView(); //$form['form']
        return $this->render('main/review/form.html.twig', $forRender);
    }
}