<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 21/07/2018
 * Time: 09:55
 */

namespace App\UI\Action\Api;

use App\Domain\Models\User;
use App\Domain\Repository\PostRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class TogglePostLike
 * @Route(
 *     "/favoured/{id}",
 *     name="toogle_post_heart",
 *     methods={"POST"}
 * )
 */
class TogglePostLike
{
    /**
     * @var PostRepository
     */
    private $postRepository;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * TogglePostLike constructor.
     * @param PostRepository        $postRepository
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(
        PostRepository $postRepository,
        TokenStorageInterface $tokenStorage
    ) {
        $this->postRepository = $postRepository;
        $this->tokenStorage   = $tokenStorage;
    }

    /**
     * @param string $id
     *
     * @return JsonResponse
     */
    public function __invoke(string $id)
    {
        $post = $this->postRepository->findOneBy(['id' => $id]);
        /** @var User $currentUser */
        $currentUser = $this->tokenStorage->getToken()->getUser();
        $favouredBy  = $post->getFavouredBy();
        foreach ($favouredBy as $fav) {
            if ($fav->getId() === $currentUser->getId()) {
                $post->removeFavouredBy($currentUser);
                $this->postRepository->update();
                $favouredByCount = count($post->getFavouredBy());

                return new JsonResponse(['hearts' => $favouredByCount]);
            }
        }
        $post->addFavouredBy($currentUser);
        $this->postRepository->update();
        $favouredByCount = count($post->getFavouredBy());

        return new JsonResponse(['hearts' => $favouredByCount]);
    }
}
