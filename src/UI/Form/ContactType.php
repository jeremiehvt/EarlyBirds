<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 11/06/2018
 * Time: 22:48
 */

namespace App\UI\Form;

use App\Domain\DTO\ContactDTO;
use App\Domain\DTO\Interfaces\ContactDTOInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ContactType
 * @package App\UI\Form
 */
class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder,
                              array $options
    ) {
        $builder
            ->add('message', TextareaType::class, [
                'label'   => false,
                'required' => true,
                'attr' => [
                    'placeholder' =>'votre message'
                ]
            ])

            ->add('author', TextType::class, [
                'label'   => false,
                'required' => true,
                'attr' => [
                    'placeholder' =>'votre nom et prénom'
                ]
            ])

            ->add('subject', TextType::class, [
                'label'   => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'sujet du mail'
                ]
            ])

            ->add('mail', TextType::class, [
                'label'   => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'votre email'
                ]
            ])

            ->add('marketing', CheckboxType::class, [
                 'label'    => false,
                 'required' => false
              ]
            )

            ->add('response', CheckboxType::class, [
                    'label'    => false,
                    'required' => true
                ]
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactDTOInterface::class,
            'empty_data' => function (FormInterface $form) {
                return new ContactDTO(
                    $form->get('author')->getData(),
                    $form->get('message')->getData(),
                    $form->get('subject')->getData(),
                    $form->get('mail')->getData(),
                    $form->get('marketing')->getData(),
                    $form->get('response')->getData()
                );
            },
            'label' => false
        ]);
    }
}
