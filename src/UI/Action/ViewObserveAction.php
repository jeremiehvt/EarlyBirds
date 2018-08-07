<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 18/07/2018
 * Time: 09:32
 */

namespace App\UI\Action;

use App\Domain\Repository\ObserveRepository;
use App\UI\Responder\Interfaces\ViewObserveResponderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ViewObserveAction
 * @Route(
 *     "/voir-observation-{id}",
 *     name="app_view_observe",
 *     methods={"GET"}
 * )
 */
class ViewObserveAction
{
    /**
     * @var ObserveRepository
     */
    private $observeRepository;

    /**
     * ViewObserveAction constructor.
     * @param ObserveRepository $observeRepository
     */
    public function __construct(ObserveRepository $observeRepository)
    {
        $this->observeRepository = $observeRepository;
    }

    /**
     * @param Request                       $request
     * @param                               $id
     * @param ViewObserveResponderInterface $responder
     *
     * @return mixed
     */
    public function __invoke(Request $request, $id, ViewObserveResponderInterface $responder)
    {
        $referer = $request->headers->get('referer');
        $observe = $this->observeRepository->findOneBy(['id' => $id]);

        return $responder($observe, $referer);
    }
}
