<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 20/07/2018
 * Time: 16:58
 */

namespace App\UI\Action\Api;

use App\Domain\Repository\PostRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route(
 *     path="/actualite/search-post-{search}",
 *     methods={"GET"}
 * )
 * Class GETPostsBySearch
 */
class GETPostsBySearch
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
        $search   = $request->attributes->get('search');
        $listPost = $this->postRepository->findBySearch($search);

        return new JsonResponse($listPost, 200);
    }

}