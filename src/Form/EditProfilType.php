<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class EditProfilType extends RegistrationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('Password', RepeatedType::class, [
            'label' => 'Password',
            'constraints' => [
                new Length(['min' => 8])
            ],
            'type' => PasswordType::class,
            'invalid_message' => 'Les deux mots de passe doivent être identiques!',
            'required' => false,
            'first_options' => array('label' => 'Password'),
            'second_options' => array('label' => 'Confirm password')
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
