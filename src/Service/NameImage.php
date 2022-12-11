<?php
namespace App\Service;

class NameImage{
    public function name($plante, $photoRepository){
        $nom_plante = $plante->getNom();
        $images_existantes = $photoRepository->findBy(['plante' => $plante]);
        $nombre_images = count($images_existantes);
        if (substr($nom_plante, 0, 2) == "L'"){
            $nom_plante = substr($nom_plante, 2);
        }
        elseif((substr($nom_plante, 0 , 3) == "La ") or (substr($nom_plante, 0 , 3) == "Le ")){
            $nom_plante = substr($nom_plante, 3);
        }
        if ($nombre_images == 0){
            $nom_fichier = $nom_plante .".jpg";
        }
        elseif ($nombre_images > 0){
            $nombre = strval($nombre_images);
            $nom_fichier = $nom_plante .strval($nombre_images);
            $nom_fichier = $nom_fichier .".jpg";
        }
        return $nom_fichier;
    }
}
?>