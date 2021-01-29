<?php


namespace App\Controller\Main;


use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends BaseController
{
    /**
     * @Route("/user", name="user")
     * @return Response
     */
    public function index(){
        $forRender = parent::renderDefault();
        return $this->render('main/index.html.twig', $forRender);
    }

    /**
     * @Route("/user/create", name="user_create")
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

            return $this->redirectToRoute('home');
        }

        $forRender = parent::renderDefault();
        $forRender['title'] = 'Регистрация';
        $forRender['form'] = $form->createView();
        return $this->render('main/user/registration.html.twig', $forRender);
    }
}