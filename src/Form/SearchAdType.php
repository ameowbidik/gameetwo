<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchAdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('query', SearchType::class, [
            'label' => false,
            'attr' => [
                'placeholder' => 'Rechercher une annonce',
            ],
        ])
        ->add('submit', SubmitType::class, [
            'label' => '<i class="fas fa-search"></i>',
            'label_html' => true,
        ])
    ;
    $builder->setMethod('GET');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => [
                'novalidate' => 'novalidate',
            ]
        ]);
    }
}
