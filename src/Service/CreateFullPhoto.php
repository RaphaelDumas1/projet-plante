<?php
namespace App\Service;

use App\Entity\Photo;

class CreateFullPhoto{
    public function create($url, $plante, $manager){
        $photo = new Photo();
        $photo->setURL($url);
        $photo->setPlante($plante);
        $manager->persist($photo);
        $manager->flush();
    }
}