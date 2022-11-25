<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeControler extends AbstractController
{
    /**
    * @Route("/Home", name="home")
    */
    public function home(): Response
    {
        return $this->render('Plantes/home.html.twig');
    }
}