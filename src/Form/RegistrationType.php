<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Vich\UploaderBundle\Form\Type\VichFileType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('Name', TextType::class, [
                'label' => 'Name',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 50])
                ],
                'invalid_message' => 'La longueur maximale est de 50 caractères!'
            ])
            ->add('FirstName', TextType::class, [
                'label' => 'Firstname',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 50])
                ],
                'invalid_message' => 'La longueur maximale est de 50 caractères!'
            ])
            ->add('Birthdate', BirthdayType::class, [
                'label' => 'Birth date',
                'required' => true,
                //'format' => 'dd-MMM-y',
                'years' => range(date('Y') - 100, date('Y')),
                'widget' => 'single_text',
                'input' => 'datetime',
            ])
            ->add('Username', TextType::class, [
                'label' => 'Username',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 50])
                ],
                'invalid_message' => 'La longueur maximale autorisée est de 50 caractères!'
            ])
            ->add('EmailAddress', EmailType::class, [
                'label' => 'Email address',
                'required' => true,
                'constraints' => new Email(),
                'invalid_message' => 'Veuillez saisir une adresse email conforme!',
            ])
            ->add('Password', RepeatedType::class, [
                'label' => 'Password',
                'constraints' => [
                    new Length(['min' => 8])
                ],
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent être identiques!',
                'required' => true,
                'first_options' => array('label' => 'Password'),
                'second_options' => array('label' => 'Confirm password')
            ])
            ->add('Phone', TelType::class, [
                'label' => 'Phone',
                'constraints' => [
                    new Regex(['pattern' => '/[0-9]{10}/'])
                ],
                'invalid_message' => 'Le numéro de téléphone à dix chiffres!'
            ])
            ->add('Address', TextType::class, [
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
            ->add('PostalCode', TextType::class, [
                'label' => 'Postal code',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 10]),
                ],
                'invalid_message' => 'La longueur maxi est de 10 caractères!'
            ])
            ->add('City', TextType::class, [
                'label' => 'City',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 50])
                ],
                'invalid_message' => 'La longueur maximale ne doit depassée 50 caractères'
            ])
            ->add('Country', CountryType::class, [
                'label' => 'Country',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 50])
                ],
                'invalid_message' => 'La longueur max ne doit pas depassé 50 caractères'
            ])
            /*->add('avatar', VichFileType::class, [
                'label' => 'Avatar',
                'data_class' => null,
                'required' => false,
            ])
            ->add('Enregistrer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary btn-block'
                ]
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
