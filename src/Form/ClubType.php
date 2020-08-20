<?php

namespace App\Form;

use App\Entity\Club;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ClubType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextareaType::class, [
                'label' => 'Name',
                'required' => true,
                'constraints' => [
                  new NotBlank(),
                  new Length(['max' => 50])
                ],
                'invalid_message' => 'La taille du nom dépasse la longueur maximale autorisée'
            ])
            ->add('emailAddress', TextareaType::class, [
                'label' => 'Email address',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 50])
                ],
                'invalid_message' => 'La taille de cet email dépasse la longueur max autorisée'
            ])
            ->add('phone', TelType::class, [
                'label' => 'Phone',
                'required' => true,
                'constraints' => new Regex(['pattern' => '/[0-9]{10}/']),
                'invalid_message' => 'Le numéro de téléphone doit correspondre à dix chiffres!'
            ])
            ->add('address', TelType::class, [
                'label' => 'Address',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 50])
                ],
                'invalid_message' => 'La longueur de cette adresse est trop longue'
            ])
            ->add('number', NumberType::class, [
                'label' => 'Number',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 10])
                ],
                'invalid_message' => 'Il faut une longueur max de 10 caractères'
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'Postal code',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 25])
                ],
                'invalid_message' => 'Il faut une longueur max de 25 caractères'
            ])
            ->add('city', TextType::class, [
                'label' => 'City',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 50])
                ],
                'invalid_message' => 'Ne dépasse pas la longueur max autorisée!'
            ])
            ->add('country', CountryType::class, [
                'label' => 'Country',
                'required' => true,
                'multiple' => false,
                'expanded' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Club::class,
        ]);
    }
}
