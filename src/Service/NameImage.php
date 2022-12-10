<?php
namespace App\Service;

class NameImage{
    public function name($plante, $photoRepository){
        $nom_plante = $plante->getNom();
        $images_existantes = $photoRepository->findBy(['plante' => $plante]);
        $nombre_images = count($images_existantes);
        $nom_plante = str_replace('.jpg', '', $nom_plante);
        if ($nombre_images == 0){
            $nom_fichier = $nom_plante .".jpg";
        }
        elseif ($nombre_images > 0){
            $nombre = strval($nombre_images);
            $nom_fichier = $nom_plante .strval($nombre_images) . ".jpg";
        }
        return $nom_fichier;
    }
}
?>