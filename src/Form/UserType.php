<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Imię',
                'trim' => true,
                'empty_data' => '',
                'attr' => [
                    'class' => 'form-control custom-input',
                    'maxlength' => 50,
                ]
            ])
            ->add('surname', TextType::class, [
                'label' => 'Nazwisko',
                'trim' => true,
                'empty_data' => '',
                'attr' => [
                    'class' => 'form-control custom-input',
                    'maxlength' => 50,
                ]
            ])
            ->add('username', TextType::class, [
                'label' => 'Login użytkownika',
                'disabled' => (in_array('editUser', $options['validation_groups'])) ? true : false,
                'trim' => true,
                'empty_data' => '',
                'attr' => [
                    'class' => 'form-control custom-input',
                    'maxlength' => 6,
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adres e-mail',
                'trim' => true,
                'empty_data' => '',
                'attr' => [
                    'class' => 'form-control custom-input',
                    'maxlength' => 255
                ]
            ])
            ->add('isActive', ChoiceType::class, [
                'label' => 'Status',
                'empty_data' => '1',
                'choices' => [
                    'Aktywny' => true,
                    'Niekatywny' => false
                ],
                'attr' => [
                    'class' => 'form-control custom-input',
                ]
            ])
            ->add('userRole', EntityType::class, array(
                'label' => 'Wybierz rolę',
                'multiple' => false,
                'expanded' => true,
                'required' => true,
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'choice_attr' => function(Role $role, $key, $value) {
                    return [
                        'radio_class' => 'custom-label-radio',
                    ];
                },
                'class' => Role::class,
                'choice_label' => 'description',
            ))
            ->add('save', SubmitType::class, [
                'label' => $options['save_button_label'],
                'attr' => [
                    'class' => 'btn btn-primary float-right'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Users::class,
            'save_button_label' => 'Dodaj użytkownika',
            'validation_groups' => array(
                Users::class,
                'addUser',
            )
        ]);
    }
}
