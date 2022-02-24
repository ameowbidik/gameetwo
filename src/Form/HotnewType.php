<?php

namespace App\Form;

use App\Entity\Hotnew;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class HotnewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Nom de l\'actualité',
                'attr' => [
                    'placeholder' => 'Entrez le nom de l\'actualité'
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            // ->add('slug')
            ->add('content', TextareaType::class, [
                'label' => 'Contenu',
                'attr' => [
                    'rows' => 5,
                    'placeholder' => 'Entrez le contenu de l\'annonce'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 10,
                        'max' => 1500,
                        'minMessage' => 'Le contenu doit contenir au minimum {{ limit }} caractères',
                        'minMessage' => 'La contenu doit contenir au minimum {{ limit }} caractères',
                    ])
                ]
            ])
            ->add('create_at', DateTimeType::class, [
                'label' => 'Créé le :',
                'date_widget' => 'single_text',
            ])
            ->add('publish_at', DateTimeType::class, [
                'label' => 'Publié le :',
                'date_widget' => 'single_text',
            ])
            // ->add('datetime')
            // ->add('edit_at')
            ->add('picture', FileType::class, [
                'label' => 'Importer une image',
            ])
            // ->add('user')
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'button',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hotnew::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}
