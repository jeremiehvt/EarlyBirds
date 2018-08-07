<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 16/07/2018
 * Time: 21:43
 */

namespace App\UI\Form;

use App\Domain\DTO\Interfaces\UpdateObserveDTOInterface;
use App\Domain\DTO\UpdateObserveDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UpdateObserveType extends AbstractType
{
    /**
     * @param FormBuilderInterface  $builder
     * @param array                 $options
     */
    public function buildForm(
        FormBuilderInterface $builder,
        array                $options
    ) {
        $builder
            ->add('ref', TextType::class, [
                'label'    => false,
                'required' => false,
                'attr'  => [
                    'placeholder'  => 'veuillez choisir un oiseau',
                    'autocomplete' => 'off'
                ]
            ])
            ->add('description',TextareaType::class, [
                'label'    => false,
                'required' => true,
                'attr'  => [
                    'placeholder' => 'description'
                ]
            ])
            ->add('latitude',TextType::class,[
                'label'    => false,
                'required' => true,
                'attr'  => [
                    'placeholder' => 'latitude'
                ]
            ])
            ->add('longitude',TextType::class, [
                'label'    => false,
                'required' => true,
                'attr'  => [
                    'placeholder' => 'longitude'
                ]
            ])
            ->add('obsDate', DateType::class, [
                   'label'       => false,
                   'widget'      => 'single_text',
                   'required' => true

               ]
            )
            ->add('img',FileType::class, [
                'label' => false,
                'required' => false
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(
        OptionsResolver $resolver
    ) {
        $resolver->setDefaults([
           'data_class' => UpdateObserveDTOInterface::class,
           'empty_data' => function (FormInterface $form) {
               return new UpdateObserveDTO(
                   $form->get('ref')->getData(),
                   $form->get('description')->getData(),
                   $form->get('latitude')->getData(),
                   $form->get('longitude')->getData(),
                   $form->get('obsDate')->getData(),
                   $form->get('img')->getData()
               );
           },
           'label'      => false
       ]);
    }
}