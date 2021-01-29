<?php


namespace App\Controller\Main;


use Symfony\Component\Routing\Annotation\Route;

class TestClass extends BaseController
{
    /**
     * @Route("/", name="home")
     */
    public function index(){
        $forRender = parent::renderDefault();
        return $this->render('main/index.html.twig', $forRender);
    }
}