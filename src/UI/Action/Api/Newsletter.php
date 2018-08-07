<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 21/07/2018
 * Time: 23:46
 */

namespace App\UI\Action\Api;

use App\Domain\Models\Newsletter as NewsletterEntity;
use App\Domain\Repository\NewsletterRepository;
use App\Services\Interfaces\MailerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class Newsletter
 * @Route(
 *     "/newsletter/{email}",
 *     name="app_newsletter",
 *     methods={"POST"}
 * )
 */
class Newsletter
{
    /**
     * @var NewsletterRepository
     */
    private $newsletterRepository;
    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * Newsletter constructor.
     * @param NewsletterRepository $newsletterRepository
     * @param MailerInterface      $mailer
     */
    public function __construct(
        NewsletterRepository $newsletterRepository,
        MailerInterface $mailer
    ) {
        $this->newsletterRepository = $newsletterRepository;
        $this->mailer               = $mailer;
    }

    /**
     * @param $email
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function __invoke($email)
    {
        $newsletterEmail = $this->newsletterRepository->findOneBy(['email' => $email]);

        if ($newsletterEmail) {
            if ($newsletterEmail->getActive() === true) {
                $response = true;
            } else {
                $newsletterEmail->setActive(true);
                $this->newsletterRepository->update();
                $response[$newsletterEmail->getEmail()] = $newsletterEmail->getActive();
                $this->mailer->sendConfirmNewsletter($newsletterEmail);
            }
        } else {
            $newsletter = new NewsletterEntity();
            $newsletter
                ->setEmail($email)
                ->setActive(true);
            $this->newsletterRepository->save($newsletter);
            $response[$newsletter->getEmail()] = $newsletter->getActive();
            $this->mailer->sendConfirmNewsletter($newsletter);
        }

        return new JsonResponse($response);
    }
}
