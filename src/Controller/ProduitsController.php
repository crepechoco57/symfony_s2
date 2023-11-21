<?php

namespace App\Controller;

use App\Entity\Photos;
use App\Entity\Produits;
use App\Form\ProduitsType;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProduitsController extends AbstractController{

    #[Route('/produits', name: 'app_produits')]
public function afficherProduit(ProduitsRepository $produitsRepository): Response
{
    return $this->render('produits/afficher_produits.html.twig', [
        'produits' => $produitsRepository->findAll()
    ]);
}

#[Route('/ajouter-produits', name: 'app_ajouter_produits')]
public function ajouterProduits(Request $request, EntityManagerInterface $em): Response
{
    $produits = new Produits();
    $form = $this->createForm(ProduitsType::class, $produits);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
              $em->persist($produits);
              $em->flush();

        }

    return $this->render('produits/ajouter_produits.html.twig', [
        'form' => $form->createView()
    ]);
}
}