<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Member;
use App\Entity\Nursery;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class NurseryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameChild', TextType::class, [
                'label' => 'Name of child',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 25])
                ],
                'invalid_message' => 'La longueure maximale est de 25 caractères!'
            ])
            ->add('firstName', TextType::class, [
                'label' => 'First name of child',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 25])
                ],
                'invalid_message' => 'La longueure maximale est de 25 caractères!'
            ])
            ->add('dateCustody', DateTimeType::class, [
                'label' => 'Date of custody',
                'required' => true,
                'widget' => 'single_text',
                'input' => 'datetime',
            ])
            ->add('totalPrice', MoneyType::class, [
                'label' => 'Total price',
                'required' => true,
            ])
            ->add('members', EntityType::class, [
                'class' => Member::class,
                'multiple' => true,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Nursery::class,
        ]);
    }
}
