<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RaphController extends AbstractController
{
    #[Route('/raph', name: 'app_raph')]
    public function index(): Response
    {
        return $this->render('raph/index.html.twig', [
            'controller_name' => 'RaphController',
        ]);
    }
}
