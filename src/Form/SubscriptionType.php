<?php

namespace App\Form;

use App\Entity\Lesson;
use App\Entity\Subscription;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Basic' => 'Basic',
                    'Enfant' => 'Enfant',
                    'VIP' => 'VIP'
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'uk-textarea',
                    'row' => '5',
                ],
                'label_attr' => [
                    'class' => 'uk-form-label'
                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Price',
                'required' => false,
            ])
            ->add('finishedAt', ChoiceType::class, [
                'label' => 'FinishedAt',
                'required' => true,
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    '1 month' => new \DateTime('+1 month'),
                    '3 month' => new \DateTime('+3 month'),
                    '6 month' => new \DateTime('+6 month'),
                    '1 year' => new \DateTime('+12 month')
                ],
            ])
            ->add('lesson', EntityType::class, [
                'class' => Lesson::class,
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Subscription::class,
        ]);
    }
}
