<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 18/07/2018
 * Time: 17:43
 */

namespace App\UI\Form;

use App\Domain\DTO\AddPostDTO;
use App\Domain\DTO\Interfaces\AddPostDTOInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddPostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(
        FormBuilderInterface $builder,
        array                $options
    ) {

        $builder
            ->add('title', TextType::class, [
                'label'    => false,
                'required' => true,
                'attr'     => [
                    'placeholder' => 'titre de l\'article'
                ]
            ])
            ->add('content', TextareaType::class, [
                'label'    => false,
                'required' => true,
                'attr'     => [
                    'class' => 'tinymce'
                ]
            ])
            ->add('shortDesc', TextareaType::class, [
                'label'    => false,
                'required' => true,
                'attr'     => [
                    'placeholder' => 'votre description',
                    'class'       => 'counter'
                ]
            ])
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'vie de l\'association' => [
                        'CR, AG'                 => 'CR, AG' ,
                        'Bénévolat, partenariat' => 'Bénévolat, partenariat',
                        'faits marquants'        => 'faits marquants'
                    ],
                    'Évènements' => [
                        'Agenda asso'                          => 'Agenda asso' ,
                        'Autres  : exemple, Fête de la nature' => 'Autres  : exemple, Fête de la nature'
                    ],
                    'L’art d\'observer les oiseaux' => [
                        'Lieux, balades'             => 'Lieux, balades',
                        'Attitude du birdwatcher'    => 'Attitude du birdwatcher',
                        'équipement'                 => 'équipement'
                    ],
                    'Identifier un oiseau' => 'Identifier un oiseau',
                    'Ornithologie sans frontières' => [
                        'Oiseaux exotiques'    => 'Oiseaux exotiques',
                        'Voyages, expériences' => 'Voyages, expériences'
                    ],
                    'Biodiversité / environnement' => [
                        'Zones à préserver'                => 'Zones à préserver',
                        'Agriculture, jardinage, conseils' => 'Agriculture, jardinage, conseils'
                    ],
                    'Programmes de recherche et publications' => [
                        'Programmes de recherche en cours' => 'Programmes de recherche en cours',
                        'documents scientifiques'          => 'documents scientifiques'
                    ]

                ],
                'placeholder' => 'choisissez une catégorie'
            ])
            ->add('img', FileType::class, [
                'label'    => false,
                'required' => true
            ])
            ->add('miniature', FileType::class, [
                'label'    => false,
                'required' => false
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => AddPostDTOInterface::class,
                'empty_data' => function (FormInterface $form) {
                    return new AddPostDTO(
                        $form->get('title')->getData(),
                        $form->get('content')->getData(),
                        $form->get('shortDesc')->getData(),
                        $form->get('category')->getData(),
                        $form->get('img')->getData(),
                        $form->get('miniature')->getData()
                    );
                },
                'label' => false
            ]
        )
        ;
    }
}