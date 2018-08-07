<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 25/06/2018
 * Time: 14:07
 */

namespace App\UI\Action\Api;

use App\Domain\Repository\ObserveRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DeleteObserve
 * @Route(
 *     "/delobserve/{id}",
 *     name="delete_observe",
 *     methods={"DELETE"}
 * )
 * @IsGranted("ROLE_NATURALIST")
 */
class DeleteObserve
{
    /**
     * @var ObserveRepository
     */
    private $observeRepository;

    /**
     * DeleteObserve constructor.
     * @param ObserveRepository $observeRepository
     */
    public function __construct(ObserveRepository $observeRepository)
    {
        $this->observeRepository = $observeRepository;
    }

    /**
     * @param observeId $id
     *
     * @return JsonResponse
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke($id)
    {
        $observe = $this->observeRepository->findOneBy(['id' => $id]);

        $status = $this->observeRepository->remove($observe);

        return new JsonResponse($status);
    }

}