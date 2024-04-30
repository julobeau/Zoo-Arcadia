<?php

namespace App\Form;

use App\Entity\Habitat;
use App\Entity\RapportVeterinaireHabitat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class RapportVeterinaireHabitatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createdAt', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Date :',
                'view_timezone' => 'Europe/Paris',
                'label_attr' => [
                    'class' => 'form-label text-primary mt-3'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('etat', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '3',
                    'maxlength' => '255'
                ],
                'label' => 'Etat :',
                'label_attr' => [
                    'class' => 'form-label text-primary mt-3'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('rapport', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'rows' => '10',
                ],
                'row_attr' => ['class' => 'text-editor', 'id' => '...'],
                'label' => 'Rapport détaillé :',
                'label_attr' => [
                    'class' => 'form-label text-primary mt-3'
                ],
            ])
            ->add('habitat', EntityType::class, [
                'class' => Habitat::class,
                'choice_label' => 'nom',
                'attr' => [
                    'class' => 'form-select',
                ],
                'label' => 'Habitat :',
                'label_attr' => [
                    'class' => 'form-label text-primary mt-3'
                ],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-3'
                ],
                'label' => 'Enregistrer'
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'sanitize_html' => true,
            'data_class' => RapportVeterinaireHabitat::class,
        ]);
    }
}
