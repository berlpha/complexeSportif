<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Lesson;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Vich\UploaderBundle\Form\Type\VichFileType;

class UserType extends AbstractType
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
                'invalid_message' => 'La longueure maximale est de 50 caractères!'
            ])
            ->add('firstName', TextType::class, [
                'label' => 'First Name',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 50]),
                ],
                'invalid_message' => 'La longueur maximale est de 50 caractères!'
            ])
            ->add('birthdate', BirthdayType::class, [
                'label' => 'Birthdate',
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day'
                ],
                'required' => true,
                //'format' => 'dd-MMM-y',
                'years' => range(date('Y') - 100, date('Y')),
                'widget' => 'single_text',
                'input' => 'datetime',
            ])
            ->add('username', TextType::class, [
                'label' => 'Username',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 50]),
                ],
                'invalid_message' => 'La longueur doit être de 50 caractères maximales!'
            ])
            ->add('emailAddress', EmailType::class, [
                'label' => 'Email address',
                'required' => true,
                'constraints' => New Email(),
                'invalid_message' => 'Cet\'adresse email n\'est pas conforme!'
            ])
            /*->add('password', PasswordType::class, [
                'label' => 'Password',
                'required' => true,
                'constraints' => new Length(['min' => 8]),
                'invalid_message' => 'Il faut un minimum de 8 caractères!'
            ])*/
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
            ->add('phone', TelType::class, [
                'label' => 'Phone',
                'required' => true,
                'constraints' => new Regex(['pattern' => '/^[0-9]{10}$/']),
                'invalid_message' => 'Le numéro de téléphone doit correspondre à dix chiffres!'
            ])
            ->add('address', TextType::class, [
                'label' => 'Address',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 50]),
                ],
                'invalid_message' => 'La longueur maximale ne doit pas dépassée 50 caractères!'
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
                    new Regex(['pattern' => '/^[0-9]{4}$/']),
                    //new NotBlank(),
                    //new Length(['max' => 4])
                ],
                'invalid_message' => 'Il faut un maximum de 4 caractères!'
            ])
            ->add('city', TextType::class, [
                'label' => 'City',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 50])
                ],
                'invalid_message' => 'La longueur maximale ne doit pas dépassée 50 caractères!'
            ])
            ->add('country', CountryType::class, [
                'label' => 'Country',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 50]),
                ],
                'invalid_message' => 'Il ne faut pas dépasser plus de 50 caractères!'
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Rôles',
                'required' => true,
                'choices' => [
                    'member' => 'ROLE_MEMBER',
                    'coach' => 'ROLE_COACH',
                    'admin' => 'ROLE_ADMIN'
                ],
                'expanded' => true,
                'multiple' => true,
            ])
            //->add('type')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
