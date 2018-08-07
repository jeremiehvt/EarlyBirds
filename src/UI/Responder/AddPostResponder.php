<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 18/07/2018
 * Time: 22:01
 */

namespace App\UI\Responder;


use App\UI\Responder\Interfaces\AddPostResponderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class AddPostResponder implements AddPostResponderInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private $url;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * AddPostResponder constructor.
     * @param UrlGeneratorInterface $url
     * @param Environment           $twig
     */
    public function __construct(
        UrlGeneratorInterface $url,
        Environment           $twig
    ) {
        $this->url  = $url;
        $this->twig = $twig;
    }


    /**
     * @param bool $redirect
     * @param FormInterface|null $form
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(bool $redirect = false, FormInterface $form = null)
    {
        $redirect
            ? $response = new RedirectResponse($this->url->generate('app_add_post'))
            : $response = new Response($this->twig->render('addPost.html.twig',
                   ['form' => $form->createView()
        ]))
        ;

        return $response;
    }
}