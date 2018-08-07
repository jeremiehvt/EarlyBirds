<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 16/06/2018
 * Time: 21:12
 */

namespace App\UI\Action;

use App\UI\Action\Interfaces\MapActionInterface;
use App\UI\Responder\Interfaces\MapResponderInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MapAction
 * @Route(
 *     "/carte-observation-oiseaux",
 *     name="app_map",
 *     methods={"GET"}
 * )
 */
class MapAction implements MapActionInterface
{
    /**
     * @param MapResponderInterface $mapResponder
     *
     * @return mixed
     */
    public function __invoke(MapResponderInterface $mapResponder)
    {
        return $mapResponder();
    }
}
