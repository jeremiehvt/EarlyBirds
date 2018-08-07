<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 17/07/2018
 * Time: 21:59
 */

namespace App\UI\Action;

use App\UI\Action\Interfaces\DiscoverNaoActionInterface;
use App\UI\Responder\Interfaces\DiscoverNaoResponderInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(
 *     path="/decouvrir-asso-ornithologique",
 *     name="app_discover_nao",
 *     methods={"GET"}
 * )
 * Class DiscoverNaoAction
 * @package App\UI\Action
 */
class DiscoverNaoAction implements DiscoverNaoActionInterface
{
    /**
     * @var DiscoverNaoActionInterface
     */
    private $discoverNao;

    /**
     * DiscoverNaoAction constructor.
     * @param DiscoverNaoResponderInterface $discoverNaoResponder
     */
    public function __construct(DiscoverNaoResponderInterface $discoverNaoResponder)
    {
        $this->discoverNao = $discoverNaoResponder;
    }

    public function __invoke()
    {
        $responder = $this->discoverNao;
        return $responder();
    }
}