<?php
namespace App\Services;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploadService{

    public function __construct(private ParameterBagInterface $params) {}

    public function uploadImage(UploadedFile $image , ?string $folder =''){
        //renomme image et change extension
        $fichier =md5(uniqid(rand(),true)) .'.webp';
        //recupere le path paramétré dans yaml, ajoute le dossier passé en parametre
        //par exemple , yaml :blabla/blabla/folder
        $path = $this->params->get('photos_directory') .$folder;

        if (!file_exists($path .'/')) {
            mkdir ($path . '/', 0777, true);
        }    
        //move dans le pathcompilé ci dessus + le fichier et son extension modifie
        $image->move($path . '/', $fichier);

        return $fichier;
    }
}