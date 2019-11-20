<?php


namespace App\Form;

use App\Entity\Companies;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Nieaktywna' => 0,
                    'Aktywna' => 1,
                ],
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'Status',
            ])
            ->add('idCompany', TextType::class, [
//                'disabled' => (in_array('editcompany', $options['validation_groups'])) ? true : false,
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'ID',
            ])
            ->add('adIdentifier', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'AD',
            ])
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'Nazwa',
            ])
            ->add('nip', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'NIP',
            ])
            ->add('comments', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'Uwagi'
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
            'data_class' => Companies::class,
            'save_button_label' => 'Dodaj Firme',
        ]);
    }
}