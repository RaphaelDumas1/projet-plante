<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Repository\PlanteRepository;
use App\Repository\TexteBeforeRepository;
use App\Repository\TexteAfterRepository;
use App\Repository\PhotoRepository;
use App\Repository\UserRepository;
use App\Repository\PlanteCompteRepository;

use App\Entity\Plante;
use App\Entity\TexteBefore;
use App\Entity\TexteAfter;
use App\Entity\Photo;
use App\Entity\PlanteCompte;
use App\Entity\User;

use App\Form\PlanteType;
use App\Form\TexteBeforeType;
use App\Form\TexteAfterType;
use App\Form\PhotoType;
use App\Form\UserType;
use App\Form\UserAdminType;

use Doctrine\Persistence\ManagerRegistry;

use App\Service\RandomPlantGenerator;
use App\Service\DecodeBase64;
use App\Service\NameImage;
use App\Service\CreateFullPlanteCompte;
use App\Service\CreateFullPhoto;
use App\Service\GetPlantWithName;

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
    * @Route("/admin/plantes/ajouter", name="Admin-plantes-ajouter")
    */
    
    public function admin_plantes_ajouter(Request $request, EntityManagerInterface $manager)
    {
        $plante = new Plante();
        $form = $this->createForm(PlanteType::class, $plante);
        $form->handleRequest($request);


        if ($form->isSubmitted()&& $form->isValid()) {
            $plante = $form->getData();
            $plante->setActive(1);
            $manager->persist($plante);
            $manager->flush();

            return $this->redirectToRoute('Admin-plante-info', ['id' => $plante->getId()]);
         }

        return $this->render('Admin/Plantes/Ajouter/plante.html.twig', [
            'form' => $form->createView(),
        ]);
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
    
    public function admin_plantes_info(PlanteRepository $repository, int $id,TexteBeforeRepository $repository2, TexteAfterRepository $repository3, PhotoRepository $repository4): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $plantes = $repository->findBy(array('id' => $id));
        $text_before = $repository2->findBy(array('plante' => $id));
        $text_after = $repository3->findBy(array('plante' => $id));
        $photos = $repository4->findBy(array('plante' => $id));
        return $this->render('Admin/Plantes/Info/info.html.twig', [
            'plantes' => $plantes, 'text_before' => $text_before, 'text_after' => $text_after, 'photos' => $photos,
        ]);
    }

    /**
    * @Route("/admin/plantes/indice/{id}", name="Admin-plante-info-indice")
    */
    
    public function admin_plantes_info_indice(TexteBeforeRepository $repository, PlanteRepository $repository2, int $id): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $text_before = $repository->findBy(array('plante' => $id));
        $plantes = $repository2->findBy(array('id' => $id));
        return $this->render('Admin/Plantes/Info/indice.html.twig', [
            'text_before' => $text_before, 'plantes' => $plantes,
        ]);
    }

    /**
    * @Route("/admin/plantes/indice/{plante}/{plante2}/ajouter", name="Admin-plantes-indice-ajouter")
    */
    
    public function admin_plantes_indice_ajouter(PlanteRepository $repository, Request $request, EntityManagerInterface $manager,?Plante $plante, int $plante2)
    {
        $before = new TexteBefore();
        $form = $this->createForm(TexteBeforeType::class, $before);
        $form->handleRequest($request);
        $plantes = $repository->findBy(array('id' => $plante2));


        if ($form->isSubmitted()&& $form->isValid()) {
            $before = $form->getData();
            $before->setPlante($plante);
            $manager->persist($before);
            $manager->flush();

            return $this->redirectToRoute('Admin-plante-info-indice', ['id' => $plante2]);
         }

        return $this->render('Admin/Plantes/Ajouter/before.html.twig', [
            'form' => $form->createView(), 'plantes' => $plantes,
        ]);
    }
    /**
    * @Route("/admin/plantes/effacer/indice/{plante}/{id}", name="Admin-plante-indice-effacer")
    */
    
    public function plante_effacer_after(TexteBefore $id, TexteBeforeRepository $repository, EntityManagerInterface $manager, int $plante)
    {
        $manager->remove($id);
        $manager->flush();
        return $this->redirectToRoute('Admin-plante-info-indice', ['id' => $plante]);
    }

    /**
    * @Route("/admin/plantes/modifier/indice/{plante}/{id}", name="Modifier-plante-before")
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

            return $this->redirectToRoute('Admin-plante-info-indice', ['id' => $plante]);
         }

        return $this->render('Admin/Plantes/Modif/before.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/admin/plantes/reponse/{id}", name="Admin-plante-info-reponse")
    */
    
    public function admin_plantes_info_reponse(TexteAfterRepository $repository, PlanteRepository $repository2, int $id): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $text_after = $repository->findBy(array('plante' => $id));
        $plantes = $repository2->findBy(array('id' => $id));
        return $this->render('Admin/Plantes/Info/reponse.html.twig', [
            'text_after' => $text_after, 'plantes' => $plantes,
        ]);
    }

    /**
    * @Route("/admin/plantes/reponse/{plante}/{plante2}/ajouter", name="Admin-plantes-reponse-ajouter")
    */
    
    public function admin_plantes_reponse_ajouter(PlanteRepository $repository, Request $request, EntityManagerInterface $manager,?Plante $plante, int $plante2)
    {
        $after = new TexteAfter();
        $form = $this->createForm(TexteAfterType::class, $after);
        $form->handleRequest($request);
        $plantes = $repository->findBy(array('id' => $plante2));


        if ($form->isSubmitted()&& $form->isValid()) {
            $after = $form->getData();
            $after->setPlante($plante);
            $manager->persist($after);
            $manager->flush();

            return $this->redirectToRoute('Admin-plante-info-reponse', ['id' => $plante2]);
         }

        return $this->render('Admin/Plantes/Ajouter/after.html.twig', [
            'form' => $form->createView(), 'plantes' => $plantes,
        ]);
    }

    /**
    * @Route("/admin/plantes/effacer/reponse/{plante}/{id}", name="Admin-plante-reponse-effacer")
    */
    
    public function plante_effacer_before(TexteAfter $id, TexteAfterRepository $repository, EntityManagerInterface $manager, int $plante)
    {
        $manager->remove($id);
        $manager->flush();
        return $this->redirectToRoute('Admin-plante-info-reponse', ['id' => $plante]);
    }

    /**
    * @Route("/admin/plantes/modifier/reponse/{plante}/{id}", name="Modifier-plante-after")
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

            return $this->redirectToRoute('Admin-plante-info-reponse', ['id' => $plante]);
         }

        return $this->render('Admin/Plantes/Modif/after.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/admin/plantes/photo/{id}", name="Admin-plante-info-photo")
    */
    
    public function admin_plantes_info_photos(PhotoRepository $repository, PlanteRepository $repository2, int $id): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $photos = $repository->findBy(array('plante' => $id));
        $plantes = $repository2->findBy(array('id' => $id));
        return $this->render('Admin/Plantes/Info/photo.html.twig', [
            'photos' => $photos, 'plantes' => $plantes,
        ]);
    }

    /**
    * @Route("/admin/plantes/photo/{plante}/{plante2}/ajouter", name="Admin-plantes-photo-ajouter")
    */
    
    public function admin_plantes_photo_ajouter(PlanteRepository $repository, Request $request, EntityManagerInterface $manager,?Plante $plante, int $plante2)
    {
        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);
        $plantes = $repository->findBy(array('id' => $plante2));


        if ($form->isSubmitted()&& $form->isValid()) {
            $photo = $form->getData();
            $photo->setPlante($plante);
            $manager->persist($photo);
            $manager->flush();

            return $this->redirectToRoute('Admin-plante-info-photo', ['id' => $plante2]);
         }

        return $this->render('Admin/Plantes/Ajouter/photo.html.twig', [
            'form' => $form->createView(), 'plantes' => $plantes,
        ]);
    }

    /**
    * @Route("/admin/plantes/effacer/photo/{plante}/{id}", name="Admin-plante-photo-effacer")
    */
    
    public function plante_effacer_photo(Photo $id, PhotoRepository $repository, EntityManagerInterface $manager, int $plante)
    {
        $manager->remove($id);
        $manager->flush();
        return $this->redirectToRoute('Admin-plante-info-photo', ['id' => $plante]);
    }

    /**
    * @Route("/admin/plantes/modifier/photo/{plante}/{id}", name="Modifier-plante-photo")
    */
    
    public function plante_modif_photos(Photo $photo, PhotoRepository $repository, Request $request, int $plante)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($photo, true);

            return $this->redirectToRoute('Admin-plante-info-photo', ['id' => $plante]);
         }

        return $this->render('Admin/Plantes/Modif/photo.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/admin/plantes/modifier/{id}", name="Modifier-plante")
    */
    
    public function plante_modif(Plante $plante, PlanteRepository $repository, Request $request, int $id)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(PlanteType::class, $plante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($plante, true);

            return $this->redirectToRoute('Admin-plante-info', ['id' => $id]);
         }

        return $this->render('Admin/Plantes/Modif/plante.html.twig', [
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

        return $this->redirectToRoute('Admin-plantes-ancienne'); 
    }

    /**
    * @Route("/admin/plantes/remettre/{id}", name="Remettre-plante")
    */
    
    public function plante_remettre(PlanteRepository $repository, Plante $plante, int $id)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $plante->setActive(1);
        $repository->save($plante, true);

        return $this->redirectToRoute('Admin-plante-info', ['id' => $id]);
    }

    /**
    * @Route("/admin/compte", name="Admin-compte")
    */
    public function admin_compte(UserRepository $repository): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $comptes = $repository->findAll();
        return $this->render('Admin/compte.html.twig', ['comptes' => $comptes]);
    }

    /**
    * @Route("/admin/compte/ajouter", name="Admin-compte-ajouter")
    */
    
    public function admin_compte_ajouter(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $userPasswordHasher)
    {
        $user = new User();
        $form = $this->createForm(UserAdminType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted()&& $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setNiveau(1);
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('Admin-compte');
         }

        return $this->render('Admin/Compte/Ajouter/compte.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/admin/compte/{id}", name="Admin-compte-info")
    */
    
    public function admin_compte_info(UserRepository $repository, int $id, PlanteCompteRepository $repository2): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $comptes = $repository->findBy(array('id' => $id));
        $plantes_comptes = $repository2->findBy(array('user' => $id));
        return $this->render('Admin/Compte/Info/info.html.twig', [
            'comptes' => $comptes, 'plantes_comptes' => $plantes_comptes,
        ]);
    }

    /**
    * @Route("/admin/compte/plante/{id}/{plante}", name="Admin-compte-info-plante")
    */
    
    public function admin_compte_info_plante(UserRepository $repository, int $id, PlanteCompteRepository $repository2, ?Plante $plante): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $comptes = $repository->findBy(array('id' => $id));
        $plantes_comptes = $repository2->findBy(array('user' => $id, 'plante' => $plante));
        return $this->render('Admin/Compte/Info/plante.html.twig', [
            'comptes' => $comptes, 'plantes_comptes' => $plantes_comptes,
        ]);
    }

    /**
    * @Route("/admin/compte/effacer/{id}", name="Admin-Effacer-compte")
    */
    
    public function admin_effacer_compte(User $id, UserRepository $repository,PlanteCompteRepository $repository2, EntityManagerInterface $manager)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $manager->remove($id);
        $manager->flush();
        return $this->redirectToRoute('Admin-compte');
    }

     /**
    * @Route("/jouer", name="jouer")
    */
    public function jouer(RandomPlantGenerator $random_plant, PlanteRepository $plantRepository, 
    TexteBeforeRepository $textBeforeRepository, UserInterface $user, PlanteCompteRepository $planteCompteRepository, 
    PhotoRepository $photoRepository): Response
    {   
        $randPlant = $random_plant->randomPlant($plantRepository, $textBeforeRepository, $user, $planteCompteRepository, $photoRepository);
        $plante = $randPlant[0];
        $texteBefore = $randPlant[1];
        $photo = $randPlant[2];
        return $this->render('jouer.html.twig', ["plante" => $plante, "infos" => $texteBefore, "photo" => $photo]);
    }
    
        /**
    * @Route("/plantes_upload_image", name="upload-plante")
    */
    
    public function plant_image_uploader(Request $request, LoggerInterface $logger, EntityManagerInterface $manager, 
    PhotoRepository $photoRepository,  UserInterface $user, DecodeBase64 $decodeImage, NameImage $nameImage,
    CreateFullPhoto $createPhoto, CreateFullPlanteCompte $createPlanteCompte, PlanteRepository $planteRepository,
    GetPlantWithName $getPlant) 
    {   
        if ($request->isXmlHttpRequest()){
            $image = $request->query->get('image_url');
            $longitude = $request->query->get('longitude');
            $latitude = $request->query->get('latitude');
            $nom_plante = $request->query->get('nom_plante');
            $datePhoto = $request->query->get('date_photo');
            $dateValide = $request->query->get('date_valide');
            $datePhoto = strval($datePhoto);
            $plante = $getPlant->getPlant($nom_plante, $planteRepository);
            $image = $decodeImage->decode($image);
            $nom_fichier = $nameImage->name($plante, $photoRepository);    
            file_put_contents((dirname(__FILE__, 3)."/public/ImagePlantes/".$nom_fichier), $image);
            $createPlanteCompte->create($manager, $plante, $nom_fichier, $user, $longitude, $latitude, $datePhoto, $dateValide);
            $createPhoto->create($nom_fichier, $plante, $manager);
        }
        return new Response();
    }

    /**
     * @Route("/phpinfo", name="phpinfo")
     */
    public function phpinfoAction()
    {
		return new Response('<html><body>'.phpinfo().'</body></html>');
    }

}