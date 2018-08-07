<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 19/07/2018
 * Time: 14:57
 */

namespace App\UI\Responder;

use App\UI\Responder\Interfaces\DeletePostResponderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class DeletePostResponder
 *
 * @package App\UI\Responder
 */
class DeletePostResponder implements DeletePostResponderInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private $url;

    /**
     * DeletePostResponder constructor.
     * @param UrlGeneratorInterface $url
     */
    public function __construct(UrlGeneratorInterface $url)
    {
        $this->url = $url;
    }

    /**
     * @return RedirectResponse
     */
    public function __invoke()
    {
        $response = new RedirectResponse($this->url->generate('app_actuality'));
        return $response;
    }
}
