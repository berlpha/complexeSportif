<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lesson', ChoiceType::class, [
                'choices' => [
                    'zumba' => 'zumba',
                    'natation' => 'natation',
                    'boxe' => 'boxe',
                    'foot' => 'foot',
                    'footSal' => 'footSal',
                    'tennis' => 'tennis',
                    'athlétisme' => 'athletisme',
                    'fitness' => 'fitness',
                    'karate' => 'karaté',
                    'basket' => 'basket'
                ],
            ])
            //->add('coach')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
