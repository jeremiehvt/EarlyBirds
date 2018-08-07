<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 17/06/2018
 * Time: 21:16
 */

namespace App\UI\Action;

use App\Services\Interfaces\SearchObservesInterface;
use App\UI\Action\Interfaces\MapObservesActionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MapObservesAction
 * @package App\UI\Action
 * @Route(
 *     "/recherche-les-dernieres-observations",
 *      name="app_last_observe",
 *      methods={"GET"}
 * )
 */
class MapObservesAction implements MapObservesActionInterface
{
    /**
     * @param SearchObservesInterface $searchObserves
     */
    public function __invoke(SearchObservesInterface $searchObserves)
    {
        return $searchObserves();
    }
}
