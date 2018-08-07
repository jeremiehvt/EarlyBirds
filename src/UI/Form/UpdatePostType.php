<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 18/07/2018
 * Time: 17:44
 */

namespace App\UI\Form;

use App\Domain\DTO\UpdatePostDTO;
use App\Domain\DTO\Interfaces\UpdatePostDTOInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UpdatePostType
 * @package App\UI\Form
 */
class UpdatePostType extends AbstractType
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
                    'vie de l\'association'                   => 'vie de l\'association',
                    'Évènements'                              => 'Évènements',
                    'L’art d\'observer les oiseaux'           => 'L’art d\'observer les oiseaux',
                    'Identifier un oiseau'                    => 'Identifier un oiseau',
                    'Ornithologie sans frontières'            => 'Ornithologie sans frontières',
                    'Biodiversité , environnement'            => 'Biodiversité , environnement',
                    'Programmes de recherche et publications' => 'Programmes de recherche et publications'
                ],
                'placeholder' => 'choisissez une catégorie'
            ])
            ->add('img', FileType::class, [
                'label'    => false,
                'required' => false
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
                    'data_class' => UpdatePostDTOInterface::class,
                    'empty_data' => function (FormInterface $form) {
                        return new UpdatePostDTO(
                            $form->get('title')->getData(),
                            $form->get('content')->getData(),
                            $form->get('shortDesc')->getData(),
                            $form->get('category')->getData(),
                            $form->get('img')->getData(),
                            $form->get('miniature')->getData()
                        );
                    },
                    'label' =>false
                ]
            )
        ;
    }
}