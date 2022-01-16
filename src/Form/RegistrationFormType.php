<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('fname', TextType::class,[
            'label' => 'Prénom',
            'attr'=>[
                'placeholder'=>'Prénom'
            ]
        ])
        ->add('lname', TextType::class,[
            'label' =>'Nom',
            'attr'=>[
                'placeholder'=>'Nom'
            ]
        ])
        ->add('email', EmailType::class,[
            'label' => 'Email',
            'attr'=>[
                'placeholder'=>'email'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
