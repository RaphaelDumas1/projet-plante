<?php
namespace App\Service;

class CalculateLevel{
    function calculate($user, $planteCompteRepository){
        $plantes_trouvees = $planteCompteRepository->findBy(['user' => $user]);
        $nombre_plantes_trouvees = count($plantes_trouvees);
        $level = intval($nombre_plantes_trouvees / 3);
        return $level;
    }
}
?>