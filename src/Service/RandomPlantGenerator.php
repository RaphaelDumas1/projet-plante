<?php
namespace App\Service;

class RandomPlantGenerator
{
    public function randomPlant($plantRepository, $textBeforeRepository, $user, $planteCompteRepository, 
    $photoRepository, $textAfterRepository): array
    {   
        $userId = $user->getId();
        $userLevel = $user->getNiveau();
        $foundPlants = $planteCompteRepository->findBy(['user' => $userId]);
        $plantes = $plantRepository->findBy(['Active' => 1]);
        foreach($plantes as $key=>$plan){
            foreach($foundPlants as $p){
                $t = $p->getPlante();
                if ($plan == $t){
                    unset($plantes[$key]);  
                }
            }
            $r = $plan->getNiveau();
            if ($r < $userLevel){
                unset($plantes[$key]); 
            }
        }
        $plantes = array_values($plantes);
        $nombre_plante = count($plantes);
        $nombre_aleatoire = rand(0, $nombre_plante - 1);
        $plante_aleatoire = $plantes[$nombre_aleatoire];
        $plante_id = $plante_aleatoire->getId();
        $plante = $plantRepository->findBy(['id' => $plante_id]);
        $plante = $plante[0];
        $photo = $photoRepository->findBy(['plante' => $plante]);
        $photo = $photo[0];
        $photo = $photo->getUrl();
        $texte_before = $textBeforeRepository->findBy(['plante' => $plante_id]);
        $texte_after = $textAfterRepository->findBy(['plante' => $plante_id]);
        $result = [$plante, $texte_before, $photo, $texte_after];
        return $result;
    }
}
?>