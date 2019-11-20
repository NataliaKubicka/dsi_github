<?php


namespace App\Form;


use App\Entity\Servers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ip', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'Adres IP',
            ])
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'Nazwa',
            ])
            ->add('localization', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'Lokalizacja',
            ])
            ->add('esxi', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'Adres ESXi',
            ])
            ->add('ups', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'Adres UPS',
            ])
            ->add('printerUrl', TextType::class, [
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'Strona do instalacji drukarki',
            ])
            ->add('serverGroup', ChoiceType::class, [
                'choices' => [
                    'Wrocław - Słonimskiego' => 1,
                    'Wrocław - Ślężna' => 2,
                    'Oddziały w Polsce' => 3,
                    'Oddziały Impel Cash Solutions' => 4,
                ],
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'label' => 'Grupa serwera',
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
            'data_class' => Servers::class,
            'save_button_label' => 'Dodaj serwer',
        ]);
    }
}
