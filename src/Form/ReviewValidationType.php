<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewValidationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'disabled' => true,
                'label' => 'Pseudo :',
                'label_attr' => [
                    'class' => 'form-label text-primary mt-3'
                ],
                ])
            ->add('comment', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'disabled' => true,
                'label' => 'Commentaire :',
                'label_attr' => [
                    'class' => 'form-label text-primary mt-3'
                ],
                ])
            ->add('note', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'disabled' => true,
                'label' => 'Note :',
                'label_attr' => [
                    'class' => 'form-label text-primary mt-3'
                ],
                ])
            ->add('Validate', SubmitType::class, [
                'attr' => [
                'class' => 'btn btn-primary mt-3'
                ],
                'label' => 'Valider'
                ])
            ->add('Reject', SubmitType::class, [
                'attr' => [
                'class' => 'btn btn-primary mt-3'
                ],
                'label' => 'Rejeter'
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
