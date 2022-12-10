<?php
namespace App\Service;

class RandomPlantGenerator
{
    public function randomPlant($plantRepository, $textBeforeRepository, $user, $planteCompteRepository): array
    {   
        $userId = $user->getId();
        $foundPlants = $planteCompteRepository->findBy(['user' => $userId]);
        $plantes = $plantRepository->findBy(['Active' => 1]);
        foreach($plantes as $key=>$plan){
            foreach($foundPlants as $p){
                $t = $p->getPlante();
                if ($plan == $t){
                    unset($plantes[$key]);  
                }
            }
        }
        $plantes = array_values($plantes);
        $nombre_plante = count($plantes);
        $nombre_aleatoire = rand(0, $nombre_plante - 1);
        $plante_aleatoire = $plantes[$nombre_aleatoire];
        $plante_id = $plante_aleatoire->getId();
        $plante = $plantRepository->findBy(['id' => $plante_id]);
        $plante = $plante[0];
        $texte_before = $textBeforeRepository->findBy(['plante' => $plante_id]);
        $result = [$plante, $texte_before];
        return $result;
    }
}
?>