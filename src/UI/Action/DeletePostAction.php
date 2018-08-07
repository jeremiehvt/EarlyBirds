<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 19/07/2018
 * Time: 14:54
 */

namespace App\UI\Action;

use App\Domain\Repository\PostRepository;
use App\UI\Responder\Interfaces\DeletePostResponderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route(
 *     path="/delete-post-{id}",
 *     name="app_delete_post",
 *     methods={"POST"}
 * )
 * Class DeletePostAction
 * @package App\UI\Action
 */
class DeletePostAction
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var DeletePostResponderInterface
     */
    private $deletePostResponder;

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
     * @param DeletePostResponderInterface  $deletePostResponder
     * @param AuthorizationCheckerInterface $authChecker
     * @param TokenStorageInterface         $token
     */
    public function __construct(
        PostRepository                $postRepository,
        DeletePostResponderInterface  $deletePostResponder,
        AuthorizationCheckerInterface $authChecker,
        TokenStorageInterface         $token
    ) {
        $this->postRepository      = $postRepository;
        $this->deletePostResponder = $deletePostResponder;
        $this->authChecker         = $authChecker;
        $this->token               = $token;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $id = $request->attributes->get('id');
        $post = $this->postRepository->findOneBy(['id' => $id]);

        if (true === $this->authChecker->isGranted('ROLE_USER')) {
            $userPostId = $post->getAuthor()->getId();
            $uId = $this->token->getToken()->getUser();
            $userId = $uId->getId();

            if ( $userId === $userPostId) {
                $this->postRepository->delete($post);
            } else {
                throw new AccessDeniedException('Vous n\'ètes pas le propriétaire de cet
            article, vous ne pouvez pas le modifié');
            }
        } elseif (true === $this->authChecker->isGranted('ROLE_ADMIN')){
            $this->postRepository->delete($post);
        } else {
            throw new AccessDeniedException('Vous n\'ètes pas le propriétaire de cet
            article, vous ne pouvez pas le modifié');
        }

        $responder = $this->deletePostResponder;
        return $responder();
    }
}