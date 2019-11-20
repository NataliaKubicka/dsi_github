<?php


namespace App\Form;

use App\Entity\Ups;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'Miasto'
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'Adres'
            ])
            ->add('localization', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'Lokalizacja'
            ])
            ->add('assignment', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'Przypisanie'
            ])
            ->add('ip', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'Adres IP'
            ])
            ->add('model', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'Model'
            ])
            ->add('sn', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'Numer SN'
            ])
            ->add('info', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'Informacje'
            ])
            ->add('save', SubmitType::class, [
                'label' => $options['save_button_label'],
                'attr' => [
                    'class' => 'btn btn-primary float-right'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ups::class,
            'save_button_label' => 'Dodaj Ups',
        ]);
    }
}