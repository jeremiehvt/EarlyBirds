<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 15/06/2018
 * Time: 13:59
 */

namespace App\UI\Action;

use App\Domain\Repository\ObserveRepository;
use App\UI\Action\Interfaces\LastObservesActionInterface;
use App\UI\Responder\Interfaces\LastObservesResponderInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LastObservesAction
 * @Route(
 *     "/dernieres-observations",
 *     name="app_lastobserve",
 *     methods={"GET"}
 * )
 */
class LastObservesAction implements LastObservesActionInterface
{
    /**
     * @var ObserveRepository
     */
    private $observeRepository;

    /**
     * LastObservesAction constructor.
     * @param ObserveRepository $observeRepository
     */
    public function __construct(
        ObserveRepository $observeRepository
    ) {
        $this->observeRepository = $observeRepository;
    }

    /**
     * @param LastObservesResponderInterface $lastObservesResponder
     *
     * @return mixed
     */
    public function __invoke(
        LastObservesResponderInterface $lastObservesResponder
    ) {
        $observes = $this->observeRepository->findValidate();

        return $lastObservesResponder($observes);
    }
}
