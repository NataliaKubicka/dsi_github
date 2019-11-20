<?php


namespace App\Form;


use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;

class RecoveryPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("email", EmailType::class, [
                "label" => "Email",
                "attr" => [
                    "class" => "form-control",
                    "id" => "basic-url",
                    "placeholder" => "Twój zarejestrowany w serwisie adres email"
                ],
                "constraints" => [
                    new Email(array("message" => "Invalid Email"))
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Wyślij',
                'attr' => [
                    'class' => 'btn btn-primary float-right'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Users::class,
            'validation_groups' => array(
                'recoveryPassword'
            )


        ));
    }
}