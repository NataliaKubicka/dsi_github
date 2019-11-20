<?php


namespace App\Form;


use App\Entity\ProbitUsers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProbitUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'Imie',
            ])
            ->add('surname', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'Nazwisko',
            ])
            ->add('number', IntegerType::class, [
//                'disabled' => (in_array('editprobituser', $options['validation_groups'])) ? true : false,
//                'disabled' =>
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'Numer Probit',
            ])
            ->add('localization', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'Lokalizacja',
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
            'data_class' => ProbitUsers::class,
            'save_button_label' => 'Dodaj Ups',
//            'validation_groups' => array(
//                ProbitUsers::class,
//                'addups',
//            ),
        ]);
    }
}