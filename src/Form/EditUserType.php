<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('username', TextType::class, [
            'attr'=> [
                'class' => 'form-control',
                'readonly'=>'True'
            ],
            'label'=> 'Pseudo'
        ])
        ->add('roles', ChoiceType::class, [
            'choices'=> [
            'Admin'=>'ROLE_ADMIN',
            'Utilisateur'=>'ROLE_USER',
            'Financier'=>'ROLE_FIN',
            'Secretaire'=>'ROLE_SEC'
            ],
            'expanded'=> true,
            'multiple'=> true,
            'label'=> 'Rôles'
            ])
        ->add('email', EmailType::class, [
            'constraints' => [
             new NotBlank([
            'message'=> 'Merci de saisir une adresse email'
            ])
            ],
            'required'=> true,
            'attr'=> [
                'class' => 'form-control'
                ]
            ])
        ->add('createdAt', DateType::class,[
            'attr'=> [
            'class' => 'form-control'
        ],
        'label'=> 'Adhesion'
        ])
        ->add('fname', TextType::class, [
            'attr'=> [
                'class' => 'form-control',
                'readonly'=>'True'
            ],
            'label'=> 'Prénom'
            ])
        ->add('lname', TextType::class, [
            'attr'=> [
                'class' => 'form-control',
                'readonly'=>'True'
            ],
            'label'=> 'Nom'
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
