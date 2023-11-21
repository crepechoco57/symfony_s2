<?php

namespace App\Form;

use App\Entity\Produits;
use App\Entity\Categories;
use App\Form\ReferencesType;
use App\Entity\Distributeurs;
use Symfony\Component\Form\AbstractType;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, [
                'label'=>'nom du produit : ',
               
            ])
            ->add('description',TextareaType::class , [
                'label' => 'Description du produit : ',
            ])
            ->add('prix',MoneyType::class,[
                'label'=>'prix du produit : ',
            ])
            // ->add('createdAt', DateTimeImmutableType::class, [
            //     'label' => 'Date de création : ',
            //     'widget' => 'single_text', // Utilisez le widget 'single_text' pour les champs de type date
            // ])
            //Formulaire imbriqués:

            //Formulaire Enfant (qui demande l'ajout d'une référence) et crée un id automatiquement
            //- Ajoute la référence du produit
            ->add('reference',ReferencesType::class,[
                'label'=> 'réference du produit :',
            ])
            //Recupère l'entité 'Catégorie' pour Affichage et insertion de la FK choisie dans la table
            //La classe (l'enfant)pour affichage du $name de categories(va l'enregistrer , l'associer au submit)
            ->add('categorie',EntityType::class,[
                'label'=> 'categorie du prod : ',
                //on spécifie la classe
                'class'=> Categories::class,
                 'choice_label'=>'name',
                
                ])
                //Récupère l'entité 'distributeur' pour Affichage et insertion de la FK choisie dans la table
                //expanded: fait des checkbox
            ->add('distributeur',EntityType::class, [
                'label'=> 'choix du distributeur : ',
                'class'=>Distributeurs::class,
                'choice_label'=>'name',
                'multiple'=> true,
                'expanded'=> true,
                
                
            ])
       
            ->add('submit', SubmitType::class ,[
            'attr' => ['id' => 'submit_produit']
        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }
}
