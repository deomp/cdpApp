<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Contributions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class FinAddContributionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('amount')
            ->add('period') 
            ->add('paymentmode', ChoiceType::class, [
                'choices' => [
                    '' => [
                        'Selectionnez' => '0',
                    ],
                    'Banques' => [
                        'EquityBCDC' => 'EquityBCDC',
                        'TMB' => 'TMB',
                    ],
                    'Paiment Mobile' => [
                        'AfriMoney' => 'AfriMoney',
                        'AirtelMoney' => 'Airtel Money',
                        'M-Pesa' => 'M-Pesa',
                        'OrangeMoney' => 'Orange Money',
                    ],
                    'Carte Bancaire' => [
                        'MasterCard' => 'MasterCard',
                        'Visa' => 'Visa',
                    ],
                ],
            ])
            ->add('proof', FileType::class, [
                'label' => 'Preuve de Paiement',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'image/jpg',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document or an Image format',
                    ])
                ],
            ])
            ->add('users', EntityType::class, [
                'class' => Users::class,
                'mapped'=> false,
                'choice_label' => 'fname',
                'label' =>'Membre',
                'choice_value' =>'fname'
                
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contributions::class,
        ]);
    }
}
