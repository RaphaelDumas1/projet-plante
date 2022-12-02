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
use App\Entity\TexteBefore;
use App\Entity\TexteAfter;
use App\Entity\Photo;

use App\Form\PlanteType;
use App\Form\TexteBeforeType;
use App\Form\TexteAfterType;

use Doctrine\Persistence\ManagerRegistry;


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
    * @Route("/home", name="Menu")
    */
    public function home(): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        return $this->render('Plantes/home.html.twig');
    }

    /**
    * @Route("/admin", name="Admin")
    */
    public function admin(): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        return $this->render('Admin/admin.html.twig');
    }

    /**
    * @Route("/admin/plantes", name="Admin-plantes")
    */
    public function admin_plantes(PlanteRepository $repository): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $plantes = $repository->findBy(['Active' => '1']);
        $active = 1;
        return $this->render('Admin/plantes.html.twig', ['plantes' => $plantes, 'active' => $active,]);
    }

    /**
    * @Route("/admin/plantes/ancienne", name="Admin-plantes-ancienne")
    */
    public function admin_plantes_ancienne(PlanteRepository $repository): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $plantes = $repository->findBy(['Active' => '0']);
        $active = 0; 
        return $this->render('Admin/plantes.html.twig', ['plantes' => $plantes, 'active' => $active,]);
    }

    /**
    * @Route("/admin/plantes/{id}", name="Admin-plante-info")
    */
    
    public function admin_plantes_info(PlanteRepository $repository, int $id,TexteBeforeRepository $repository2, TexteAfterRepository $repository3): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
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
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(PlanteType::class, $plante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($plante, true);

            return $this->redirectToRoute('Modifier-plante-before', ['plante' => $plante->getId()]);
         }

        return $this->render('Admin/modifplante.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
    * @Route("/admin/plantes/modifier/{plante}/2", name="Modifier-plante-before")
    */
    
    public function plante_modif_before(TexteBefore $before, TexteBeforeRepository $repository, Request $request, int $plante)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(TexteBeforeType::class, $before);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($before, true);

            return $this->redirectToRoute('Modifier-plante-after', ['plante' => $plante]);
         }

        return $this->render('Admin/modifplantebefore.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/admin/plantes/modifier/{plante}/3", name="Modifier-plante-after")
    */
    
    public function plante_modif_after(TexteAfter $after, TexteAfterRepository $repository, Request $request, int $plante)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(TexteAfterType::class, $after);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($after, true);

            return $this->redirectToRoute('Admin-plante-info', ['id' => $plante]);
         }

        return $this->render('Admin/modifplanteafter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/admin/plantes/effacer/{id}", name="Effacer-plante")
    */
    
    public function plante_effacer(PlanteRepository $repository, Plante $plante)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $plante->setActive(0);
        $repository->save($plante, true);

        return $this->redirectToRoute('Admin-plantes'); 
    }
}