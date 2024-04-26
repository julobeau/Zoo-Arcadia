<?php

namespace App\Form;

use App\Entity\Habitat;
use App\Entity\ImagesAnimaux;
use App\Entity\ImagesHabitat;
use App\Repository\ImagesHabitatRepository;
use App\Repository\ImagesAnimauxRepository;

use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class AnimalImageEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', EntityType::class, [
                'class' => ImagesAnimaux::class,
                'query_builder' => function (ImagesAnimauxRepository $r) use ( $options ) {
                    return $r->createQueryBuilder('i')
                        ->where('i.animal = ' . $options['animal'])
                        ->orderBy('i.image', 'ASC');
                        //->setParameter('habitat', $options['habitat']);
                },
                'choice_label' => 'image',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Images :',
                'label_attr' => [
                    'class' => 'form-label text-primary mt-3'
                ],

            ])
            ->add('supprimer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-3'
                ],
                'label' => 'Supprimer'
                ]
            )
            ->add('newImage', FileType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Nouvelle photo (Taille maximum 2M):',
                'label_attr' => [
                    'class' => 'form-label text-primary mt-3'
                ],
                'required' => false,
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
            ->add('add', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-3'
                ],
                'label' => 'Ajouter'
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'animal' => 1,
        ]);
    }
}
