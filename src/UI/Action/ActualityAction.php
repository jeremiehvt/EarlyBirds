<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 18/07/2018
 * Time: 14:16
 */

namespace App\UI\Action;

use App\Domain\Repository\PostRepository;
use App\UI\Action\Interfaces\ActualityActionInterface;
use App\UI\Responder\Interfaces\ActualityResponderInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(
 *     path="/actualite",
 *     name="app_actuality",
 *     methods={"GET"}
 * )
 * Class ActualityAction
 * @package App\UI\Action
 */
class ActualityAction implements ActualityActionInterface
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var ActualityResponderInterface
     */
    private $actualityResponder;

    /**
     * ActualityAction constructor.
     * @param PostRepository              $postRepository
     * @param ActualityResponderInterface $actualityResponder
     */
    public function __construct(
        PostRepository              $postRepository,
        ActualityResponderInterface $actualityResponder
    ) {
        $this->postRepository     = $postRepository;
        $this->actualityResponder = $actualityResponder;
    }

    /**
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function __invoke()
    {
        $post = $this->postRepository->findLastFivePost();
        $lastPost = $this->postRepository->findLastArticle();
        $responder = $this->actualityResponder;
        return $responder($post, $lastPost);
    }
}