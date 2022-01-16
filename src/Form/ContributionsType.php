<?php

namespace App\Form;

use App\Entity\Paymentmodes;
use App\Entity\Contributions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ContributionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('amount', TextType::class, [
            'attr'=> [
                'class' => 'form-control'
            ],
            'label'=> 'Montant'
        ])
        ->add('period', HiddenType::class, [
            'attr'=> [
                'class' => 'form-control'
            ],
            'label'=> 'Periode',
            
        ])
        /*->add('paymentmodes', EntityType::class, [
            'class' => Paymentmodes::class,
            'choice_label' => 'displayName',
        ])*/
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contributions::class,
        ]);
    }
}
