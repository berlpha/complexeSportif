<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Coach;
use App\Entity\Field;
use App\Entity\Hall;
use App\Entity\Lesson;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('beginAt', DateTimeType::class, [
                'label' => 'Bigin at',
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                    'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second',
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank()
                ],
                //'date_format' => 'dd-MMM-y',
                'years' => range(date('Y') + 20, date('Y')),
                'widget' => 'single_text',
                'input' => 'datetime',
            ])
            ->add('endAt', DateTimeType::class, [
                'label' => 'End at',
                /*'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                    'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second',
                ],*/
                'required' => true,
                'constraints' => [
                    new NotBlank()
                ],
                'years' => range(date('Y') + 20, date('Y')),
                'widget' => 'single_text',
                'input' => 'datetime',
            ])
            ->add('title', TextType::class, [
                'label' => 'Title',
                'required' => false,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 50])
                ],
                'invalid_message' => 'La longueur maxi autorisée est de 20 caractères'
            ])
            ->add('priceTotal', MoneyType::class, [
                'label' => 'Price',
                'required' => false,
            ])
            ->add('hall', EntityType::class, [
                'class' => Hall::class,
                'multiple' => false,
                'required' => false,
                'empty_data' => 'Choisir une salle'
            ])
            ->add('field', EntityType::class, [
                'class' => Field::class,
                'multiple' => false,
                'required' => false,
                'empty_data' => 'Choisir un terrain'
            ])
            /*->add('users', EntityType::class, [
                'class' => Coach::class,
                'multiple' => false,
                'required' => false,
                'empty_data' => 'Choissir une personne'
            ])*/
            ->add('lesson', EntityType::class, [
                'class' => Lesson::class,
                'multiple' => true,
                'required' => false,
                'empty_data' => 'Choisir une leçon'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
