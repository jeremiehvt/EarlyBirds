<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 18/06/2018
 * Time: 15:40
 */

namespace App\UI\Action\Api;

use App\Domain\Models\Observe;
use App\Domain\Repository\ObserveRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class ToggleObserveLike
 * @Route(
 *     "/lastobserve/{id}/heart",
 *     name="toggle_observe_heart",
 *     methods={"POST"}
 * )
 */
class ToggleObserveLike
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var ObserveRepository
     */
    private $observeRepository;

    /**
     * ToggleObserveLike constructor.
     * @param ObserveRepository     $observeRepository
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(
        ObserveRepository $observeRepository,
        TokenStorageInterface $tokenStorage
    ) {
        $this->tokenStorage      = $tokenStorage;
        $this->observeRepository = $observeRepository;
    }

    /**
     * @param string $id
     *
     * @return JsonResponse
     */
    public function __invoke(string $id)
    {
        $observe     = $this->observeRepository->findOneBy(['id' => $id]);
        $currentUser = $this->tokenStorage->getToken()->getUser();

        $upvoters = $observe->getUpvoter();

        foreach ($upvoters as $upvoter) {
            if ($upvoter->getId() === $currentUser->getId()) {
                /** @var Observe $observe */
                $observe->removeUpvoter($currentUser);
                $this->observeRepository->update();

                $upvoterCount = count($observe->getUpvoter());

                return new JsonResponse(['hearts' => $upvoterCount]);
            }
        }
        /** @var Observe $observe */
        $observe->addUpvoter($currentUser);

        $this->observeRepository->update();

        $upvoterCount = count($observe->getUpvoter());

        return new JsonResponse(['hearts' => $upvoterCount]);
    }
}
