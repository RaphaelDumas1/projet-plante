<?php
namespace App\Service;

use App\Entity\PlanteCompte;

class CreateFullPlanteCompte{
    public function create($manager, $plante, $photo, $user, $longitude, $latitude, $datePhoto, $dateValide){
        $planteCompte = new PlanteCompte();
        $planteCompte->setPhoto($photo);
        $planteCompte->setDatePhoto((\DateTime::createFromFormat('d-m-Y', $datePhoto)) );
        $planteCompte->setDateValide((\DateTime::createFromFormat('d-m-Y', $dateValide)) );
        $planteCompte->setLongitude($longitude);
        $planteCompte->setLatitude($latitude);
        $planteCompte->setUser($user);
        $planteCompte->setPlante($plante);
        $manager->persist($planteCompte);
        $manager->flush();
    }
}
?>