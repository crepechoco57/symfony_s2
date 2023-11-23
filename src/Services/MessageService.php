<?php
namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

Class MessageService {
    

    #[Route('produits/messages', name :'app_message_produit')]
    public function aficherMessageService(){
     $messages = [
        'je vais faire un café',
        'Le chien se lèche le derrière',
        'Pourquoi pas créer une quatrieme phrase',
        'Voici la quatrièmre phrase sans point.
        '];
        $index = array_rand($messages);
        
        return $messages[$index];
    }
}