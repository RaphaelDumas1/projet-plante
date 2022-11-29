<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\PlanteRepository;
use App\Repository\TexteBeforeRepository;
use App\Repository\TexteAfterRepository;

use App\Entity\Plante;

use App\Form\PlanteType;


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

    /**
    * @Route("/admin", name="Admin")
    */
    public function admin(): Response
    {
        return $this->render('Admin/admin.html.twig');
    }

    /**
    * @Route("/admin/plantes", name="Admin-plantes")
    */
    public function admin_plantes(PlanteRepository $repository): Response
    {
        $plantes = $repository->findBy(['Active' => '1']);
        $active = 1;
        return $this->render('Admin/plantes.html.twig', ['plantes' => $plantes, 'active' => $active,]);
    }

    /**
    * @Route("/admin/plantes/ancienne", name="Admin-plantes-ancienne")
    */
    public function admin_plantes_ancienne(PlanteRepository $repository): Response
    {
        $plantes = $repository->findBy(['Active' => '0']);
        $active = 0; 
        return $this->render('Admin/plantes.html.twig', ['plantes' => $plantes, 'active' => $active,]);
    }

    /**
    * @Route("/admin/plantes/{id}", name="Admin-plante-info")
    */
    
    public function admin_plantes_info(PlanteRepository $repository, int $id,TexteBeforeRepository $repository2, TexteAfterRepository $repository3): Response
    {
        $plantes = $repository->findBy(array('id' => $id));
        $text_before = $repository2->findBy(array('plante' => $id));
        $text_after = $repository3->findBy(array('plante' => $id));
        return $this->render('Admin/infoplantes.html.twig', [
            'plantes' => $plantes, 'text_before' => $text_before, 'text_after' => $text_after
        ]);
    }

    /**
    * @Route("/admin/plantes/modifier/{id}", name="Modifier-plante")
    */
    
    public function plante_modif(Plante $plante, PlanteRepository $repository, Request $request)
    {
        $form = $this->createForm(PlanteType::class, $plante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($plante, true);

            return $this->redirectToRoute('Admin-plante-info', ['id' => $plante->getId()]);
         }

        return $this->render('Admin/modifplante.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/admin/plantes/effacer/{id}", name="Effacer-plante")
    */
    
    public function plante_effacer(PlanteRepository $repository, Plante $plante)
    {
        $plante->setActive(0);
        $repository->save($plante, true);

        return $this->redirectToRoute('Admin-plantes'); 
    }
}