<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

class FillDBController extends AbstractController
{
    #[Route('/qwerty12345', name: 'qwerty12345')]
    public function index(ManagerRegistry $doctrine): Response
    {   
        $json_plante = file_get_contents(dirname(__FILE__, 2).'/DataFixtures/Ressources/Models/data.json');
        $tableau_plante = json_decode($json_plante, true);
        foreach ($tableau_plante as $plantes) {
            $entityManager = $doctrine->getManager();
            $plante = new Plante();
            $plante->setNom($plantes["name"]);
            $plante->setNiveau($plantes["level"]);
            $plante->setActive(True);
            $entityManager->persist($plante);
            foreach ($plantes["photos"] as $photos){
                $photo = new Photo();
                $photo->setURL($photos);
                $photo->setPlante($plante);
                $entityManager->persist($photo);
            foreach ($plantes["before"] as $befores){
                $before = new TexteBefore();
                if (array_key_exists("text", $befores) == True){
                    $before->setTexte($befores["text"]);
                } 
                if (array_key_exists("title", $befores) == True){
                    $before->setTitre($befores["title"]);
                } 
                if (array_key_exists("logo", $befores) == True){
                    $before->setLogo($befores["logo"]);
                }
                $before->setPlante($plante);
                $entityManager->persist($before);
                }
            foreach ($plantes["after"] as $afters){
                    $after = new TexteAfter();
                    if (array_key_exists("text", $afters) == True){
                        $after->setTexte($afters["text"]);
                    } 
                    if (array_key_exists("title", $afters) == True){
                        $after->setTitre($afters["title"]);
                    } 
                    if (array_key_exists("logo", $afters) == True){
                        $after->setLogo($afters["logo"]);
                    }
                    $after->setPlante($plante);
                    $entityManager->persist($after);
                }
            }
            $entityManager->flush();
        }
        return $this->redirectToRoute("Premiere_page");
    }
}
