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
        $form = $this->createForm(UserType::class, $user);
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
}