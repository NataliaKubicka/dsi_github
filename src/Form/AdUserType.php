<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                    'minlength' => 3
                ],
                'label' => 'Login użytkownika',
                'required' => false,
            ])
            ->add('surname', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                    'minlength' => 3
                ],
                'label' => 'Nazwisko użytkownika',
                'required' => false,
            ])
            ->add('search', SubmitType::class, [
                'label' => 'Szukaj',
                'attr' => [
                    'class' => 'btn btn-primary float-right'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}