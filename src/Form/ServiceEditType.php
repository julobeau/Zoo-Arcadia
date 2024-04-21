<?php

namespace App\Form;

use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ServiceEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Nom :',
                'label_attr' => [
                    'class' => 'form-label text-primary mt-3'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'rows' => '10',
                ],
                'row_attr' => ['class' => 'text-editor', 'id' => '...'],
                'label' => 'Description :',
                'label_attr' => [
                    'class' => 'form-label text-primary mt-3'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('photo', FileType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Photo (Taille maximum 2M):',
                'label_attr' => [
                    'class' => 'form-label text-primary mt-3'
                ],
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Assert\Image([
                        'maxSize' => '2M',
                        'maxSizeMessage' => 'Le fichier ne doit pas dépasser 2Méga',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Seuls les fichiers jpeg, png et webp sont acceptés.'
                ])
                ]

            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-3'
                ],
                'label' => 'Modifier'
                ]
            )
    ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
