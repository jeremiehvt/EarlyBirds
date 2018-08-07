<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 18/07/2018
 * Time: 09:52
 */

namespace App\UI\Responder;

use App\Domain\Models\Observe;
use App\UI\Responder\Interfaces\ViewObserveResponderInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class ViewObserveResponder implements ViewObserveResponderInterface
{
    /**
     * @var Environment
     */
    private $environment;

    /**
     * ViewObserveResponder constructor.
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @param Observe $observe
     *
     * @return mixed|Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(Observe $observe, string $referer)
    {
        return new Response($this->environment->render('viewObserve.html.twig', [
            'observe' => $observe,
            'referer' => $referer,
        ]));
    }
}
