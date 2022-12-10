<?php
namespace App\Service;

use App\Entity\PlanteCompte;

class GetPlantWithName{
    public function getPlant($nom, $planteRepository){
        $plante = $planteRepository->findBy(['nom' => $nom]);
        $plante = $plante[0];
        return $plante;
    }
}
?>