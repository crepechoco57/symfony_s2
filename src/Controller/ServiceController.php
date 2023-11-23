<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceController extends AbstractController{
 #[Route('produits/message-service',name:'app_produits_message_service')]
 public function messageServiceProduit(){
    $majuscule = "tout mettre en majuscule";
    return $this->render('services/message.html.twig',[
        'majuscule' => $majuscule    
    ]);
 }
    
}