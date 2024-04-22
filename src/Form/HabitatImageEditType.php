<?php

namespace App\Form;

use App\Entity\Habitat;
use App\Entity\ImagesHabitat;
use App\Repository\ImagesHabitatRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HabitatImageEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //$habitat = $options['habitat'];
        $builder
            ->add('image', EntityType::class, [
                'class' => ImagesHabitat::class,
                'query_builder' => function (ImagesHabitatRepository $r) use ( $options ) {
                    return $r->createQueryBuilder('i')
                        ->where('i.habitat = ' . $options['habitat']);
                        //->orderBy('i.image', 'ASC')
                        //->setParameter('habitat', $options['habitat']);
                },
                'choice_label' => 'image',
            ])
            ->add('habitat', EntityType::class, [
                'class' => Habitat::class,
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ImagesHabitat::class,
            'habitat' => 1,
        ]);
    }
}
