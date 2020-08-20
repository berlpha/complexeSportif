<?php

namespace App\Form;

use App\Entity\Club;
use App\Entity\Field;
use App\Entity\Lesson;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class FieldType extends AbstractType
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
                'invalid_message' => 'La limite des caractères autorisée est de 50!'
            ])
            ->add('capacity', IntegerType::class, [
                'label' => 'Capacity',
                'required' => true,
                'constraints' => new NotBlank(),
                'invalid_message' => 'Ce champ est obligatoire!'
            ])
            ->add('priceHour', MoneyType::class)
            ->add('club', EntityType::class, [
                'class' => Club::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Field::class,
        ]);
    }
}
