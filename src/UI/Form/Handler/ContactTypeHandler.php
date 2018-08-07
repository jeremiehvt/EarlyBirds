<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 12/06/2018
 * Time: 09:36
 */

namespace App\UI\Form\Handler;

use App\Domain\Builder\Interfaces\ContactBuilderInterface;
use App\Domain\Repository\ContactRepository;
use App\Services\Mailer;
use App\UI\Form\Handler\Interfaces\ContactTypeHandlerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ContactTypeHandler implements ContactTypeHandlerInterface
{
    /**
     * @var ContactBuilderInterface
     */
    private $contactBuilder;

    /**
     * @var ContactRepository
     */
    private $contactRepository;

    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * @var FlashBagInterface
     */
    private $flash;

    /**
     * ContactTypeHandler constructor.
     * @param ContactBuilderInterface $contactBuilder
     * @param ContactRepository       $contactRepository
     * @param Mailer                  $mailer
     * @param FlashBagInterface       $flash
     */
    public function __construct(
        ContactBuilderInterface $contactBuilder,
        ContactRepository       $contactRepository,
        Mailer                  $mailer,
        FlashBagInterface       $flash
    ) {
        $this->contactBuilder    = $contactBuilder;
        $this->contactRepository = $contactRepository;
        $this->mailer            = $mailer;
        $this->flash             = $flash;
    }


    /**
     * @param FormInterface $form
     * @return bool
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function handle(FormInterface $form)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $this->contactBuilder->create(
                $form->getData()->author,
                $form->getData()->message,
                $form->getData()->subject,
                $form->getData()->mail,
                $form->getData()->marketing,
                $form->getData()->response
            );

            $this->contactRepository->save($this->contactBuilder->getContact());

            $this->mailer->sendContactMail($this->contactBuilder->getContact());

            $this->flash->add('contact','votre message a bien été envoyé, un administrateur vous répondra dans les plus brefs délais.');

            return true;
        }

        return false;
    }
}
