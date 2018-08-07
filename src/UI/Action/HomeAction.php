<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 25/04/2018
 * Time: 14:23
 */

namespace App\UI\Action;

use App\Domain\Repository\ObserveRepository;
use App\Domain\Repository\PostRepository;
use App\UI\Action\Interfaces\HomeActionInterface;
use App\UI\Responder\Interfaces\HomeResponderInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeAction
 *
 * @Route(
 *     "/",
 *     name="app_home",
 *     methods={"GET"}
 * )
 */
final class HomeAction implements HomeActionInterface
{
    /**
     * @var ObserveRepository
     */
    private $observeRepository;
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * HomeAction constructor.
     * @param ObserveRepository $observeRepository
     * @param PostRepository    $postRepository
     */
    public function __construct(
        ObserveRepository $observeRepository,
        PostRepository $postRepository
    ) {
        $this->observeRepository = $observeRepository;
        $this->postRepository    = $postRepository;
    }

    /**
     * @param HomeResponderInterface $homeResponder
     *
     * @return mixed
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function __invoke(HomeResponderInterface $homeResponder)
    {
        $observes = $this->observeRepository->findValidateLimitTwo();
        $lastPost = $this->postRepository->findLastArticle();

        return $homeResponder($observes, $lastPost);
    }
}
