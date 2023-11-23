<?php

namespace App\Controller;

use App\Entity\Photos;
use App\Entity\Produits;
use App\Entity\Categories;
use App\Form\ProduitsType;
use App\Form\FiltreProduitType;
use App\Services\MessageService;
use App\Repository\ProduitsRepository;
use App\Services\ImageUploadService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProduitsController extends AbstractController{
// //Test DISTINCT et JOIN
// #[Route('/produitsJointure', name: 'app_produitsJointure')]
// public function afficherProduitsJointure(Request $request,ProduitsRepository $produitsRepository): Response
// {
//     return $this->render('produits/test_requete.html.twig', [
//         'datas' => $produitsRepository->getProductByCategory(),
//     ]);
// }

#[Route('/produits/messages', name: 'app_message_produit')]
public function afficherMessage(MessageService $messageService) :Response {
    $message = $messageService->aficherMessageService();

    return $this->render('produits/message_produits.html.twig',[
        'message'=> $message
    ]);
}
//Test QueryBuilder
#[Route('/QueryBuilder', name: 'app_QueryBuilder')]
public function afficherProduitsJointure(Request $request,ProduitsRepository $produitsRepository): Response
{
    $element = 'id' ;
    return $this->render('produits/test_requete.html.twig', [
        'datas' => $produitsRepository->getLastProduct($element),
        'titre' => $element
    ]);
}
    
    //Utilisation du Repository (prix descendant)
    #[Route('/produitsByIdDesc', name: 'app_produitsByIdDesc')]
public function afficherProduitsDesc(Request $request,ProduitsRepository $produitsRepository): Response
{
    $filtreForm = $this->createForm(FiltreProduitType::class);
    $filtreForm->handleRequest($request);
    return $this->render('produits/afficher_produits.html.twig', [
        'produits' => $produitsRepository->getAllProductsByIdDesc(),
        'filtreForm' => $filtreForm->createView(),
    ]);
}
//Utilisation de DQL avec parametre 
#[Route('/produitsFourchette', name: 'app_produitsFourchette')]
public function afficherProduitFilterBetween(
    Request $request,ManagerRegistry $doctrine,
    ProduitsRepository $produitRepository ): Response
{
    $filtreForm = $this->createForm(FiltreProduitType::class);
    $filtreForm->handleRequest($request);

    $filtrePrixMin = $filtreForm->get('prix_min')->getData();
    $filtrePrixMax = $filtreForm->get('prix_max')->getData();
    // $filtreCategorie = $filtreForm->get('categorie')->getData();
    // $distribRepository = $doctrine->getRepository(Distributeurs::class);
    $produitRepository = $doctrine->getRepository(Produits::class);

    if ($request->isMethod('POST') && $filtreForm->isValid()) {
        // Si le formulaire est soumis, filtre les produits par prix
        if ($filtrePrixMax !==null && $filtrePrixMin !==null){
            $produits = $produitRepository->getProductsByPriceScale($filtrePrixMin,$filtrePrixMax);
        }
            // $produits = $produitRepository->findAll();
    } else {
        // Sinon, récupère tous les produits
        $produits = $produitRepository->findAll();
    }
    return $this->render('produits/afficher_produits.html.twig', [
        'produits' => $produits,
        'filtreForm' => $filtreForm->createView(),
    ]);
}
   //Utilisation du Repository (prix Ascendant)
   #[Route('/produitsByIdAsc', name: 'app_produitsByIdAsc')]
   public function afficherProduitsAsc(Request $request,ProduitsRepository $produitsRepository): Response
   {
       $filtreForm = $this->createForm(FiltreProduitType::class);
       $filtreForm->handleRequest($request);
       return $this->render('produits/afficher_produits.html.twig', [
           'produits' => $produitsRepository->getAllProductsByIdAsc(),
           'filtreForm' => $filtreForm->createView(),
       ]);
   }
//Utilisation find(avec injection id dans url)
#[Route('/produits/{id}', name: 'app_produit_details_by')]
public function afficherProduitDetailBy(ProduitsRepository $produitsRepository,int $id): Response
{
    return $this->render('produits/afficher_produit_details_by.html.twig', [
        'produit' => $produitsRepository->find($id)
    ]);
}
//Utilisation findBy 
#[Route('/produits', name: 'app_produits')]
public function afficherProduitDetailOneBy(
    Request $request,ManagerRegistry $doctrine,
    ProduitsRepository $produitRepository ): Response
{
    $filtreForm = $this->createForm(FiltreProduitType::class);
    $filtreForm->handleRequest($request);

    $filtrePrix = $filtreForm->get('prix')->getData();
    // $filtreCategorie = $filtreForm->get('categorie')->getData();
    // $distribRepository = $doctrine->getRepository(Distributeurs::class);
    $produitRepository = $doctrine->getRepository(Produits::class);

    if ($request->isMethod('POST') && $filtreForm->isValid()) {
        // Si le formulaire est soumis, filtre les produits par prix
        if ($filtrePrix !== null) {
            $produits = $produitRepository->findBy(['prix' => $filtrePrix]);
        } else {
            $produits = $produitRepository->findAll();
            // $produits = $produitRepository->findAll();
        }
    } else {
        // Sinon, récupère tous les produits
        $produits = $produitRepository->findAll();
    }

    return $this->render('produits/afficher_produits.html.twig', [
        'produits' => $produits,
        'filtreForm' => $filtreForm->createView(),
    ]);
}
#[Route('/ajouter-produits', name: 'app_ajouter_produits')]
public function ajouterProduits(Request $request, EntityManagerInterface $em, ImageUploadService $imageUploadService): Response
{
    $produits = new Produits();
    $form = $this->createForm(ProduitsType::class, $produits);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();
            $dossier = 'produits';
            $fichier = $imageUploadService->uploadImage($image,$dossier);
            if ($fichier){
                $produits->setImage($fichier);
                $this->addFlash('success','Votre image a bien été ajoutée');
            }
              $em->persist($produits);
              $em->flush();
        }

    return $this->render('produits/ajouter_produits.html.twig', [
        'form' => $form->createView()
    ]);
}
#[Route('/produits/{id}/modifier', name: 'app_modifier_produit')]
    public function modifierProduit(

        EntityManagerInterface $em, ManagerRegistry $doctrine,int $id,Request $request,): Response
    {
        $produitsRepository = $doctrine->getRepository(Produits::class);
        $produit = $produitsRepository->find($id);

        if (!$produit) {
            throw $this->createNotFoundException('Produit non trouvé');
        }

        $form = $this->createForm(ProduitsType::class, $produit);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Pas besoin de faire persist() car l'objet est déjà géré par l'EntityManager
            $em->flush();

            return $this->redirectToRoute('app_produit_details_by', ['id' => $produit->getId()]);
        }

        return $this->render('produits/modifier_produit.html.twig', [
            'form' => $form->createView(),
            'produit' => $produit,
        ]);
    }
   

}