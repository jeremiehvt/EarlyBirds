<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 18/07/2018
 * Time: 14:26
 */

namespace App\UI\Responder;

use App\Domain\Models\Post;
use App\UI\Responder\Interfaces\ActualityResponderInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ActualityResponder implements ActualityResponderInterface
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * ActualityResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param $post|null
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(array $post, Post $lasPost = null)
    {
        $response =  new Response($this->twig->render('actuality.html.twig', [
            'posts'     =>  $post,
            'lastPost' => $lasPost
        ]));
        return $response;
    }
}