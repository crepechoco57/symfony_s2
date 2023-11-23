<?php
namespace App\Services;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploadService{

    public function __construct(private ParameterBagInterface $params) {}

    public function uploadImage(UploadedFile $image , ?string $folder =''){
        
        $fichier =md5(uniqid(rand(),true)) .'.webp';
        $path = $this->params->get('image_directory') .$folder;

        if (!file_exists($path .'/')) {
            mkdir ($path . '/', 0777, true);
        }    
        $image->move($path . '/', $fichier);

        return $fichier;
    }
}