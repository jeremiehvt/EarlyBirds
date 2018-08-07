<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 21/07/2018
 * Time: 18:33
 */

namespace App\UI\Action\Api;

use App\Domain\Repository\PostRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route(
 *     path="/delete-article-{id}",
 *     name="app_delete_article",
 *     methods={"DELETE"}
 * )
 * Class DeletePost
 * @package App\UI\Action\Api
 */
class DeletePost
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authChecker;

    /**
     * @var TokenStorageInterface
     */
    private $token;

    /**
     * DeletePostAction constructor.
     * @param PostRepository                $postRepository
     * @param AuthorizationCheckerInterface $authChecker
     * @param TokenStorageInterface         $token
     */
    public function __construct(
        PostRepository                $postRepository,
        AuthorizationCheckerInterface $authChecker,
        TokenStorageInterface         $token
    ) {
        $this->postRepository = $postRepository;
        $this->authChecker = $authChecker;
        $this->token = $token;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $id = $request->attributes->get('id');
        $post = $this->postRepository->findOneBy(['id' => $id]);
        $removePost = false;

        if (true === $this->authChecker->isGranted('ROLE_ADMIN')) {
            $this->postRepository->delete($post);
            $removePost = 'article supprimé';
        } elseif (true === $this->authChecker->isGranted('ROLE_NATURALIST')) {
            $userPostId = $post->getAuthor()->getId();
            $uId = $this->token->getToken()->getUser();
            $userId = $uId->getId();

            if ($userId !== $userPostId) {
                throw new AccessDeniedException('Vous n\'ètes pas le propriétaire de cet
                article, vous ne pouvez pas le supprimer');
            } else {
                $this->postRepository->delete($post);
                $removePost = 'article supprimé';
            }
        } else {
            throw new AccessDeniedException('Vous n\'ètes pas le propriétaire de cet
                article, vous ne pouvez pas le supprimer');
        }

        return new JsonResponse($removePost);
    }
}