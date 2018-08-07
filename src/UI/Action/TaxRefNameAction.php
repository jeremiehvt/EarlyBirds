<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 07/06/2018
 * Time: 10:44
 */

namespace App\UI\Action;

use App\Services\Interfaces\SearchBirdsInterface;
use App\UI\Action\Interfaces\TaxRefNameActionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaxRefNameAction
 * @package App\UI\Action
 * @Route(
 *     "/recherche-{name}",
 *     name="search",
 *     methods={"GET"},
 *     requirements={"name": "\D+"}
 * )
 */
class TaxRefNameAction implements TaxRefNameActionInterface
{

    /**
     * @param  SearchBirdsInterface $searchBirds
     * @param  string               $name
     * @return mixed
     */
    public function __invoke(SearchBirdsInterface $searchBirds, string $name)
    {
        return $searchBirds($name);
    }
}
