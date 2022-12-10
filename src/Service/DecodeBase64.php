<?php
namespace App\Service;

class DecodeBase64{
    public function decode($image){
        $image = str_replace('data:image/webp;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $image = base64_decode($image);
        return $image;
    } 
}
