<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 20/07/2018
 * Time: 19:25
 */

namespace App\UI\Action\Api;

use App\Domain\Repository\PostRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route(
 *     path="/actualite/search-post",
 *     methods={"GET"}
 * )
 * Class GETPostsInit
 */
class GETPostsInit
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * GETPostsBySearch constructor.
     * @param PostRepository      $postRepository
     * @param SerializerInterface $serializer
     */
    public function __construct(
        PostRepository $postRepository,
        SerializerInterface $serializer
    ) {
        $this->postRepository = $postRepository;
        $this->serializer     = $serializer;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {

        $listPost = $this->postRepository->initAll();

        return new JsonResponse($listPost, 200);
    }
}