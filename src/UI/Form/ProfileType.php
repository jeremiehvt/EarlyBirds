<?php

namespace App\UI\Form;

use App\Domain\DTO\Interfaces\ProfileDTOInterface;
use App\Domain\DTO\ProfileDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nickname', TextType::class, [
                'label'    => 'Pseudo',
                'required' => false,
            ])
            ->add('firstname', TextType::class, [
                'label'    => 'Prénom',
                'required' => false,
            ])
            ->add('lastname', TextType::class, [
                'label'    => 'Nom',
                'required' => false,
            ])
            ->add('img', FileType::class, [
                'label'    => 'Avatar',
                'required' => false,
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'        => ProfileDTOInterface::class,
            'empty_data'        => function (FormInterface $form) {
                return new ProfileDTO(
                    $form->get('nickname')->getData(),
                    $form->get('firstname')->getData(),
                    $form->get('lastname')->getData(),
                    $form->get('img')->getData()
                );
            },
            'validation_groups' => ['ImgProfile'],
            'label'             => false,
        ]);
    }
}
