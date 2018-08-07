<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 17/07/2018
 * Time: 22:05
 */

namespace App\UI\Responder;


use App\UI\Responder\Interfaces\DiscoverNaoResponderInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class DiscoverNaoResponder implements DiscoverNaoResponderInterface
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * DiscoverNaoResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke()
    {
        return new Response($this->twig->render('discoverNao.html.twig'));
    }
}