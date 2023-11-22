<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Distributeurs;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FiltreProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('prix', NumberType::class, [
            'label' => 'Filtrer par prix',
            'required' => false,
        ])
        ->add('prix_min', NumberType::class, [
            'label' => 'Filtrer par prix',
            'required' => false,
        ])
        ->add('prix_max', NumberType::class, [
            'label' => 'Filtrer par prix',
            'required' => false,
        ])
        // ->add('prix_text', NumberType::class, [
        //     'label' => false,
        //     'mapped' => false, // Ceci évite de stocker la valeur dans l'objet du formulaire
        //     'attr' => [
        //         'readonly' => true, // Empêche la modification manuelle de la valeur
        //     ],
        // ])
        // ->add('categorie', EntityType::class, [
        //     'class' => Categories::class,
        //     'label' => 'Filtrer par Categorie',
        //     'choice_label' => 'id', // Supposons que 'nom' est le champ que vous voulez afficher dans le formulaire
        //     'required' => false,
        // ])
        ->add('filtrerPrix', SubmitType::class, [
            'label' => 'Filtrer',
        ])
        ->add('filtrerPrixMinMax', SubmitType::class, [
            'label' => 'FiltrerMinMax',
        ]);

}
}
