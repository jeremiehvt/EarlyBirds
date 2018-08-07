<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 18/05/2018
 * Time: 23:56
 */

namespace App\UI\Form\Handler;

use App\Domain\Repository\UserRepository;
use App\Services\Interfaces\MailerInterface;
use App\UI\Form\Handler\Interfaces\ForgottenPasswordTypeHandlerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class ForgottenPasswordTypeHandler implements ForgottenPasswordTypeHandlerInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var TokenGeneratorInterface
     */
    private $tokenGenerator;
    /**
     * @var MailerInterface
     */
    private $mailer;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * ForgottenPasswordTypeHandler constructor.
     * @param UserRepository          $userRepository
     * @param TokenGeneratorInterface $tokenGenerator
     * @param MailerInterface         $mailer
     * @param FlashBagInterface       $flashBag
     */
    public function __construct(
        UserRepository $userRepository,
        TokenGeneratorInterface $tokenGenerator,
        MailerInterface $mailer,
        FlashBagInterface $flashBag
    ) {
        $this->userRepository = $userRepository;
        $this->tokenGenerator = $tokenGenerator;
        $this->mailer         = $mailer;
        $this->flashBag       = $flashBag;
    }

    /**
     * @param FormInterface $form
     *
     * @return bool
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(FormInterface $form): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->userRepository
                ->findOneBy(['email' => $form->getData()->email]);

            $user->setResetPasswordToken(rawurlencode($this->tokenGenerator->generateToken()));
            $this->userRepository->register($user);

            $this->mailer->sendResetPasswordTokenLink($user);

            $this->flashBag->add('login', 'Veuillez consulter votre messagerie: un email de changement de mot de passe vous a été envoyé');

            return true;
        }

        return false;
    }
}
