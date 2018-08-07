<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 19/07/2018
 * Time: 10:51
 */

namespace App\UI\Responder;

use App\Domain\DTO\Interfaces\UpdatePostDTOInterface;
use App\UI\Responder\Interfaces\UpdatePostResponderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class UpdatePostResponder implements UpdatePostResponderInterface
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var UrlGeneratorInterface
     */
    private $url;

    /**
     * UpdatePostResponder constructor.
     * @param Environment           $twig
     * @param UrlGeneratorInterface $url
     */
    public function __construct(
        Environment           $twig,
        UrlGeneratorInterface $url
    ) {
        $this->twig = $twig;
        $this->url  = $url;
    }

    /**
     * @param bool                        $redirect
     * @param FormInterface|null          $form
     * @param UpdatePostDTOInterface|null $post
     * @return RedirectResponse|Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(
        bool                   $redirect = false,
        FormInterface          $form = null,
        UpdatePostDTOInterface $post = null
    ) {
        $redirect
            ? $response = new RedirectResponse($this->url->generate('app_add_post'))
            : $response = new Response($this->twig->render('addPost.html.twig', [
                'form' => $form->createView()
            ]));
        ;

        return $response;
    }
}
