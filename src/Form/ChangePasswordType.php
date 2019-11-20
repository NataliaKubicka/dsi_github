<?php


namespace App\Form;


use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type'              => PasswordType::class,
                'required'          => false,
                'first_options'     => [
                    'label' => 'Nowe hasło',
                    'attr' => [
                        'class' => 'form-control custom-input mb-2'
                    ]
                ],
                'second_options'    => [
                    'label' => 'Powtórz hasło',
                    'attr' => [
                        'class' => 'form-control custom-input'
                    ]
            ],
                'invalid_message' => 'Podane hasła muszą być identyczne',
                'attr' => [
                    'class' => 'form-control'
                ]

            ])
            ->add('save', SubmitType::class, [
                'label' => 'Wyślij',
                'attr' => [
                    'class' => 'btn btn-primary float-left'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array(
                Users::class, 'setNewPassword'
            )

        ));
    }
}