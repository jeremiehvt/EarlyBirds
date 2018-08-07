<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 17/07/2018
 * Time: 19:00
 */

namespace App\UI\Action;

use App\Domain\Repository\ObserveRepository;
use App\UI\Action\Interfaces\DiscoverBirdsActionInterface;
use App\UI\Responder\Interfaces\DiscoverBirdsResponderInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(
 *     path="/reconnaitre-les-oiseaux",
 *     name="app_discover_birds",
 *     methods={"GET"}
 *     )
 * Class DiscoverBirdsAction
 *
 */
class DiscoverBirdsAction implements DiscoverBirdsActionInterface
{
    /**
     * @var DiscoverBirdsResponderInterface
     */
    private $discoverResponder;
    /**
     * @var ObserveRepository
     */
    private $observeRepository;

    /**
     * DiscoverBirdsAction constructor.
     * @param DiscoverBirdsResponderInterface $discoverResponder
     * @param ObserveRepository               $observeRepository
     */
    public function __construct(
        DiscoverBirdsResponderInterface $discoverResponder,
        ObserveRepository $observeRepository
    ) {
        $this->discoverResponder = $discoverResponder;
        $this->observeRepository = $observeRepository;
    }

    /**
     * @return DiscoverBirdsResponderInterface
     */
    public function __invoke()
    {
        $observes  = $this->observeRepository->findValidate();
        $responder = $this->discoverResponder;

        return $responder($observes);
    }
}