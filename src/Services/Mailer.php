<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 17/05/2018
 * Time: 22:25
 */

namespace App\Services;

use App\Domain\Models\Contact;
use App\Domain\Models\Newsletter;
use App\Domain\Models\User;
use App\Services\Interfaces\MailerInterface;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;

/**
 * Class Mailer
 */
class Mailer implements MailerInterface
{
    /**
     * Mail address of the sender
     */
    const ADMIN_EMAIL = 'admin@earlybirds.com';
    /**
     * @var Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $environment;
    /**
     * @var string
     */
    private $logoPath;

    /**
     * Mailer constructor.
     * @param Swift_Mailer $mailer
     * @param Environment  $environment
     * @param string       $logoPath
     */
    public function __construct(
        Swift_Mailer $mailer,
        Environment $environment,
        string $logoPath
    ) {
        $this->mailer      = $mailer;
        $this->environment = $environment;
        $this->logoPath    = $logoPath;
    }

    /**
     * @param User $user
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendWelcome(User $user)
    {
        $message = new Swift_Message("Bienvenue");

        $message
            ->setFrom(self::ADMIN_EMAIL)
            ->setTo($user->getEmail())
            ->setBody(
                $this->environment->render(
                    "Emails/registerConfirm.html.twig",
                    [
                        'data' => $user,
                        //'logo' => $message->embed(\Swift_Image::fromPath($this->logoPath)),
                    ]
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }

    /**
     * @param User $user
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendResetPasswordTokenLink(User $user)
    {
        $message = new Swift_Message("Votre lien de changement de mot de passe");

        $message
            ->setFrom(self::ADMIN_EMAIL)
            ->setTo($user->getEmail())
            ->setBody(
                $this->environment->render(
                    "Emails/resetPasswordToken.html.twig",
                    [
                        'data' => $user,
                    ]
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }

    /**
     * @param User $user
     * @return mixed|void
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendObservationMail(User $user)
    {
        $message = new Swift_Message("Vous avez ajouté une observation");

        $message
            ->setFrom(self::ADMIN_EMAIL)
            ->setTo($user->getEmail())
            ->setBody(
                $this->environment->render(
                    "Emails/observationMail.html.twig",
                    [
                        'data' => $user,
                    ]
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }

    /**
     * @param Contact $contact
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendContactMail(Contact $contact)
    {
        $message = new Swift_Message($contact->getSubject());

        $message
            ->setFrom([$contact->getMail()])
            ->setTo([$contact->getMail(), self::ADMIN_EMAIL])
            ->setBody(
                $this->environment->render(
                    "Emails/contactMail.html.twig",
                    [
                        'data' => $contact
                    ]
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }

    /**
     * @param Newsletter $newsletter
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendConfirmNewsletter(Newsletter $newsletter)
    {
        $message = new Swift_Message("[NAO] Confirmation abonnement newsletter");

        $message
            ->setFrom(self::ADMIN_EMAIL, $newsletter->getEmail())
            ->setTo($newsletter->getEmail())
            ->setBody(
                $this->environment->render(
                    "Emails/newsletter.html.twig",
                    [
                        'data' => $newsletter,
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }
}
