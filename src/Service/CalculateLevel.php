<?php
namespace App\Service;

class CalculateLevel{
    function calculate($user, $planteCompteRepository, $manager){
        $plantes_trouvees = $planteCompteRepository->findBy(['user' => $user]);
        $nombre_plantes_trouvees = count($plantes_trouvees);
        $level = intval($nombre_plantes_trouvees / 3 + 1);
        $user->setNiveau($level);
        $manager->persist($user);
        $manager->flush();
    }
}
?>