<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Coach;
use App\Entity\Field;
use App\Entity\Hall;
use App\Entity\Lesson;
use App\Entity\Subscription;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichFileType;

class LessonType extends AbstractType
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
                'invalid_message' => 'La longueur maxi autorisée est de 50 caractères'
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Individuel' => 'Individuel',
                    'Collectif' => 'Collectif',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Desciption',
                'attr' => [
                    'class' => 'uk-textarea',
                    'row' => '5'
                ],
                'label_attr' => [
                    'class' => 'uk-form-label'
                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Price',
                'required' => true,
            ])
            ->add('urlPicture', FileType::class, [
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
            ])
            ->add('bookings', EntityType::class, [
                'class' => Booking::class,
                'multiple' => true,
                'required' => false,
            ])
            //->add('subscriptions')
            ->add('coach', EntityType::class, [
                'class' => Coach::class,
                'choice_label' => 'username',
                'multiple' => true,
                /*'qb' => function (EntityRepository $coach)
                {
                    return $coach->createQueryBuilder('c');
                },*/
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lesson::class,
        ]);
    }
}
