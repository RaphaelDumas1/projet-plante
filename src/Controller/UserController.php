<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;

use App\Form\UserType;


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
}