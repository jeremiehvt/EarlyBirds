<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 06/05/2018
 * Time: 01:21
 */

namespace App\UI\Form\Handler;

use App\Domain\Builder\Interfaces\UserBuilderInterface;
use App\Domain\Models\User;
use App\Domain\Repository\UserRepository;
use App\Services\Interfaces\MailerInterface;
use App\Services\Mailer;
use App\UI\Form\Handler\Interfaces\RegisterTypeHandlerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class RegisterTypeHandler implements RegisterTypeHandlerInterface
{
    /**
     * @var EncoderFactoryInterface
     */
    private $encoder;
    /**
     * @var UserBuilderInterface
     */
    private $userBuilder;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * RegisterTypeHandler constructor.
     * @param EncoderFactoryInterface $encoder
     * @param UserBuilderInterface    $userBuilder
     * @param UserRepository          $userRepository
     * @param MailerInterface         $mailer
     */
    public function __construct(
        EncoderFactoryInterface $encoder,
        UserBuilderInterface $userBuilder,
        UserRepository $userRepository,
        MailerInterface $mailer
    ) {
        $this->encoder        = $encoder;
        $this->userBuilder    = $userBuilder;
        $this->userRepository = $userRepository;
        $this->mailer         = $mailer;
    }

    /**
     * @param FormInterface $registerType
     *
     * @return bool
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(FormInterface $registerType): bool
    {
        if ($registerType->isSubmitted() && $registerType->isValid()) {
            $encoder = $this->encoder->getEncoder(User::class);

            $this->userBuilder->createFromRegistration(
                $registerType->getData()->email,
                $registerType->getData()->password,
                \Closure::fromCallable([$encoder, 'encodePassword']),
                100
            );

            // Save user in db
            $this->userRepository->register($this->userBuilder->getUser());

            // Send confirmation mail
            $this->mailer->sendWelcome($this->userBuilder->getUser());

            return true;
        }

        return false;
    }
}
