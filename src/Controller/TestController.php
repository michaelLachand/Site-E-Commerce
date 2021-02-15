<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class TestController extends AbstractController
{
    /**
     * @Route("/hello/{prenom}", name="accueil")
     * @param $prenom
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index ($prenom = "World")
    {
       return $this->render('hello.html.twig',[
           'prenom' => $prenom,
       ]);
    }


}