<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label'=> 'Votre Email'
            ]);
        //champs pour modif mdp

        //PRE_SET_DATA
        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this,'preRemplirEmail']);
        $builder->add('submit',SubmitType::class,[
            'label'=> ('Modifier le mdp')
        ])
    ;
    }
    public function preRemplirEmail (FormEvent $event) :void {
        $user = $event->getData();
        if ($user instanceof User) {
            $event->getForm()->get('email')->setData($user->getEmail());
        }
    }
}
