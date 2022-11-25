<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeControler extends AbstractController
{
    /**
    * @Route("/", name="Premiere_page")
    */
    public function premiere_page(): Response
    {
        return $this->render('Plantes/premiere_page.html.twig');
    }

    /**
    * @Route("/inscription", name="Inscription")
    */
    public function inscription(): Response
    {
        return $this->render('Plantes/inscription.html.twig');
    }

    /**
    * @Route("/connexion", name="Connexion")
    */
    public function connexion(): Response
    {
        return $this->render('Plantes/connexion.html.twig');
    }

    /**
    * @Route("/home", name="Menu")
    */
    public function home(): Response
    {
        return $this->render('Plantes/home.html.twig');
    }
}