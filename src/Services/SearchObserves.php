<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 17/06/2018
 * Time: 21:14
 */

namespace App\Services;

use App\Domain\Repository\ObserveRepository;
use App\Services\Interfaces\SearchObservesInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SearchObserves
 * @package App\Services
 */
class SearchObserves implements SearchObservesInterface
{
    /**
     * @var ObserveRepository
     */
    private $observeRepository;

    /**
     * SearchObserves constructor.
     * @param ObserveRepository $observeRepository
     */
    public function __construct(ObserveRepository $observeRepository)
    {
        $this->observeRepository = $observeRepository;
    }

    public function __invoke()
    {
        $data = $this->observeRepository->findLastObservation();
        $response = new JsonResponse();
        $response->setData($data);

        return $response;
    }
}
