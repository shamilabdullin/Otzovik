<?php


namespace App\Controller\Admin;


use App\Entity\User;
use App\Form\ReviewType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminUserController extends AdminBaseController
{
    private $userRepository;
    private $reviewRepository;
    private $productRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }
    /**
     * @Route("/admin/user", name="admin_user")
     * @return Response
     */
    public function index(){
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        $forRender = parent::renderDefault();
        $forRender ['title'] = 'Пользователи';
        $forRender ['users'] = $users;
        return $this->render('admin/user/index.html.twig', $forRender);
    }
    /**
     * @Route ("admin/user/create", name="admin_user_create")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */
    public function create(Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);

        if(($form->isSubmitted()) && ($form->isValid()))
        {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles(["ROLE_USER"]);
            $em ->persist($user);
            $em ->flush();

            return $this->redirectToRoute('admin_user');
        }

        $forRender = parent::renderDefault();
        $forRender['title'] = 'Форма создания пользователя';
        $forRender['form'] = $form->createView();
        return $this->render('admin/user/form.html.twig', $forRender);
    }

    /**
     * @Route("admin/user/update/{id}", name="admin_user_update")
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function update(int $id, Request $request)
    {

        $user = $this->userRepository->getOneUser($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            if($form->get('delete')->isClicked()){
                $this->userRepository->setDeleteReview($user);
                $this->addFlash('success', 'Пользователь удален');
            }

            return $this->redirectToRoute('admin_user');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Редактирование пользователя';
        $forRender['form'] = $form->createView(); //$form['form']
        return $this->render('admin/user/form.html.twig', $forRender);
    }
}