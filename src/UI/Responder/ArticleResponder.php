<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 18/07/2018
 * Time: 15:53
 */

namespace App\UI\Responder;

use App\Domain\Models\Post;
use App\UI\Responder\Interfaces\ArticleResponderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

/**
 * Class ArticleResponder
 * @package App\UI\Responder
 */
class ArticleResponder implements ArticleResponderInterface
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
     * ArticleResponder constructor.
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
     * @param Post $post
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(bool $redirect = false, Post $post = null, FormInterface $form = null)
    {
        $redirect
            ? $response = new RedirectResponse(
                $this->url->generate('app_read_article', [
                     'id' => $post->getId()
                     ], UrlGeneratorInterface::ABSOLUTE_URL)
            )
            : $response = new Response(
                $this->twig->render(
                    'article.html.twig',
                    ['post' => $post,
                    'form' => $form->createView()]
                )
            );
        ;

        return $response;
    }

}