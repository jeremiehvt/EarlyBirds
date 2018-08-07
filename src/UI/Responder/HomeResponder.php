<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 05/05/2018
 * Time: 18:01
 */

namespace App\UI\Responder;

use App\Domain\Models\Post;
use App\UI\Responder\Interfaces\HomeResponderInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class HomeResponder implements HomeResponderInterface
{
    /**
     * @var Environment
     */
    private $environment;

    /**
     * HomeResponder constructor.
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @param array     $observes
     * @param Post|null $post
     *
     * @return mixed|Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(array $observes, ?Post $post)
    {
        return new Response(
            $this->environment->render('homepage.html.twig', [
                'observes' => $observes,
                'lastPost' => $post,
            ])
        );
    }
}
