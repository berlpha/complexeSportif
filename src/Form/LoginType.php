<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', EmailType::class, [
                'label' => 'Username',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
                'invalid_message' => 'Ce champ est obligatoire'
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password',
                'required' => true,
                'constraints' => [
                    new NotBlank()
                ],
                'invalid_message' => 'Ce champ est obligatoire'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
