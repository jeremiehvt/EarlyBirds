<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 11/06/2018
 * Time: 21:48
 */

namespace App\UI\Responder;

use App\UI\Responder\Interfaces\ContactResponderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

/**
 * Class ContactResponder
 * @package App\UI\Responder
 */
class ContactResponder implements ContactResponderInterface
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * ContactResponder constructor.
     *
     * @param Environment           $twig
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        Environment $twig,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param bool $redirect
     * @param FormInterface|null $form
     * @return mixed|RedirectResponse|Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke($redirect = false, FormInterface $form = null)
    {
        $redirect
            ? $response = new RedirectResponse($this->urlGenerator->generate('app_contact'))
            : $response = new Response($this->twig->render('contact.html.twig', [
                'form' => $form->createView()
                ])
            )
        ;

        return $response;
    }
}