<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 50])
                ],
                'invalid_message' => 'La longueur maximale est de 50 caractères!'
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Firstname',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 50])
                ],
                'invalid_message' => 'La longueur maximale est de 50 caractères!'
            ])
            ->add('phone', TelType::class, [
                'label' => 'Phone',
                'constraints' => [
                    new Regex(['pattern' => '/[0-9]{10}/'])
                ],
                'invalid_message' => 'Le numéro de téléphone à dix chiffres!'
            ])
            ->add('address', TextType::class, [
                'label' => 'Address',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 50]),
                ],
                'invalid_message' => 'La longueur est de 50 caractères maximums!'
            ])
            ->add('number', TextType::class, [
                'label' => 'Number',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 10])
                ],
                'invalid_message' => 'La longueur maximale est de 10 caractères!'
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'Postal code',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 10]),
                ],
                'invalid_message' => 'La longueur maxi est de 10 caractères!'
            ])
            ->add('city', TextType::class, [
                'label' => 'City',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 50])
                ],
                'invalid_message' => 'La longueur maximale ne doit depassée 50 caractères'
            ])
            ->add('country', CountryType::class, [
                'label' => 'Country',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 50])
                ],
                'invalid_message' => 'La longueur max ne doit pas depassé 50 caractères'
            ])
            /*->add('avatar', FileType::class, [
                'label' => 'UrlPicture (png ou jpeg)',
                'required' => false,
                //'allow_delete' => true, // not mandatory, default is true
                //'download_lik' => true, // not mandatory, default is true
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2Mi',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Fichier trop volumineux!'
                    ])
                ],
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
