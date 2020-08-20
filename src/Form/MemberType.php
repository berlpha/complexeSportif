<?php

namespace App\Form;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('firstName')
            ->add('birthdate')
            ->add('username')
            ->add('emailAddress')
            ->add('password')
            ->add('phone')
            ->add('address')
            ->add('postalCode')
            ->add('city')
            ->add('country')
            ->add('avatar')
            ->add('roles')
            ->add('createdAt')
            ->add('resetToken')
            ->add('booking')
            ->add('subscription')
            ->add('nursery')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
