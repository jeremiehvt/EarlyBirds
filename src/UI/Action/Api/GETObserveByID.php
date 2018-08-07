<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 02/07/2018
 * Time: 14:40
 */

namespace App\UI\Action\Api;

use App\Domain\Repository\ObserveRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class GETObserveByID
 * @Route(
 *     path="/search/{lat}/{long}",
 *     name="api_observe_by_coords",
 *     methods={"GET"}
 * )
 */
class GETObserveByID
{
    /**
     * @var TokenStorageInterface
     */
    private $token;

    /**
     * @var ObserveRepository
     */
    private $observeRepository;

    /**
     * GETObserveByID constructor.
     * @param TokenStorageInterface $token
     * @param ObserveRepository     $observeRepository
     */
    public function __construct(
        TokenStorageInterface $token,
        ObserveRepository $observeRepository
    ) {
        $this->token             = $token;
        $this->observeRepository = $observeRepository;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $lat  = $request->attributes->get('lat');
        $long = $request->attributes->get('long');

        $user   = $this->token->getToken()->getUser();
        $userId = $user->getId();
        $result = $this->observeRepository->findObservationByLatLong($userId, $lat, $long);

        return new JsonResponse($result, 200);
    }
}
