<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;



class UserController extends AbstractController
{
    /**
    * @Route("/Compte", name="compte")
    */
    public function compte(): Response
    {
        return $this->render('Utilisateur/compte.html.twig');
    }
}