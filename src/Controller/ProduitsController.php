<?php

namespace App\Controller;

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
public function ajouterProduits(
    Request $request,
    EntityManagerInterface $em
): Response
{
    $produits = new Produits(); // Utilisez "new Produits()" au lieu de "newProduits()"
    $form = $this->createForm(ProduitsType::class, $produits);
    //ttes les variables superglobales 
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $photoFile = $form->get('photos')->getData();

        if ($photoFile) {
            $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename.'-'.uniqid().'.'.$photoFile->guessExtension();

            // Déplacez le fichier dans le répertoire où sont stockées les photos
            try {
                $photoFile->move(
                    $this->getParameter('photos_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // Gérer les erreurs de téléchargement ici, par exemple
                // en affichant un message à l'utilisateur
            }

            // Stockez le nom du fichier dans la base de données
            $produits->setPhotos($newFilename);
        }
        //prepare et execute (persist et execute)
        $em->persist($produits);
        //insertInto
        $em->flush();
    }

    return $this->render('produits/ajouter_produits.html.twig', [
        'form' => $form->createView()
    ]);
}
}



