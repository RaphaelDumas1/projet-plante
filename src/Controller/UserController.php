<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use App\Form\UserType;
use App\Form\UserPasswordType;

use App\Repository\PlanteCompteRepository;
use App\Repository\PlanteRepository;
use App\Repository\TexteBeforeRepository;
use App\Repository\TexteAfterRepository;
use App\Repository\PhotoRepository;

class UserController extends AbstractController
{
    /**
    * @Route("/Compte", name="compte")
    */
    public function compte(): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        return $this->render('Utilisateur/compte.html.twig');
    }

    /**
    * @Route("/Compte/Modifier", name="compte-modifier")
    */
    public function compte_modifier(Request $request, EntityManagerInterface $manager)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('compte');
        }
        return $this->render('Utilisateur/comptemodifier.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/Compte/Modifier/mdp", name="compte-modifier-mdp")
    */
    public function compte_modifier_mdp(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $manager)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getUser();
        $form = $this->createForm(UserPasswordType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('compte');
        }
        return $this->render('Utilisateur/comptemodifiermdp.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/Compte/Effacer", name="compte-effacer")
    */
    public function compte_effacer(Request $request, EntityManagerInterface $manager, Session $session)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getUser();

        $manager->remove($user);
        $manager->flush();

        $session = new Session();
        $session->invalidate();
  
        return $this->redirectToRoute('Premiere_page');
    }

    /**
    * @Route("/stats", name="compte-stat")
    */
    public function compte_stat(PlanteCompteRepository $repository, PlanteRepository $repository2): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $tri = "nom";
        $user = $this->getUser();
        $plantes_comptes = $repository->findBy(array('user' => $user));
        $plantes = $repository2->findBy(array(),array('nom' => 'ASC'));
        return $this->render('Utilisateur/comptestat.html.twig', [
            'plantes_comptes' => $plantes_comptes, 'plantes' => $plantes, 'tri' => $tri,
        ]);
    }

    /**
    * @Route("/stats/date", name="compte-stat-date")
    */
    public function compte_stat_date(PlanteCompteRepository $repository, PlanteRepository $repository2): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $tri = "date";
        $user = $this->getUser();
        $plantes_comptes = $repository->findBy(array('user' => $user),array('date_valide' => 'ASC'));
        $plantes = $repository2->findAll();
        return $this->render('Utilisateur/comptestat.html.twig', [
            'plantes_comptes' => $plantes_comptes, 'plantes' => $plantes, 'tri' => $tri,
        ]);
    }

    /**
    * @Route("/stats/info/{id}", name="compte-stat-info")
    */
    public function compte_stat_info(PlanteCompteRepository $repository, int $id, TexteBeforeRepository $repository2, TexteAfterRepository $repository3, PhotoRepository $repository4): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $plantes_comptes = $repository->findBy(array('id' => $id));
        $text_before = $repository2->findAll();
        $text_after = $repository3->findAll();
        $photos = $repository4->findAll();
        return $this->render('Utilisateur/comptestatinfo.html.twig', [
            'plantes_comptes' => $plantes_comptes, 'text_before' => $text_before, 'text_after' => $text_after, 'photos' => $photos,
        ]);
    }
}