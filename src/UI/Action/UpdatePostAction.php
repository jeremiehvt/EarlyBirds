<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 19/07/2018
 * Time: 10:49
 */

namespace App\UI\Action;

use App\Domain\DTO\UpdatePostDTO;
use App\Domain\Repository\PostRepository;
use App\UI\Action\Interfaces\UpdatePostActionInterface;
use App\UI\Form\Handler\Interfaces\UpdatePostTypeHandlerInterface;
use App\UI\Form\UpdatePostType;
use App\UI\Responder\Interfaces\UpdatePostResponderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route(
 *     path="/modifier-article-{id}",
 *     name="app_update_post",
 *     methods={"GET", "POST"}
 * )
 * Class UpdatePostAction
 * @package App\UI\Action
 */
class UpdatePostAction implements UpdatePostActionInterface
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var UpdatePostResponderInterface
     */
    private $updatePostResponder;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authChecker;

    /**
     * @var TokenStorageInterface
     */
    private $token;
    /**
     * @var UpdatePostTypeHandlerInterface
     */
    private $updatePostTypeHandler;

    /**
     * UpdatePostAction constructor.
     * @param PostRepository                 $postRepository
     * @param UpdatePostResponderInterface   $updatePostResponder
     * @param FormFactoryInterface           $formFactory
     * @param AuthorizationCheckerInterface  $authChecker
     * @param TokenStorageInterface          $token
     * @param UpdatePostTypeHandlerInterface $updatePostTypeHandler
     */
    public function __construct(
        PostRepository                 $postRepository,
        UpdatePostResponderInterface   $updatePostResponder,
        FormFactoryInterface           $formFactory,
        AuthorizationCheckerInterface  $authChecker,
        TokenStorageInterface          $token,
        UpdatePostTypeHandlerInterface $updatePostTypeHandler
    ) {
        $this->postRepository        = $postRepository;
        $this->updatePostResponder   = $updatePostResponder;
        $this->formFactory           = $formFactory;
        $this->authChecker           = $authChecker;
        $this->token                 = $token;
        $this->updatePostTypeHandler = $updatePostTypeHandler;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $responder = $this->updatePostResponder;
        $id        = $request->attributes->get('id');
        $updPost   = $this->postRepository->findOneBy(['id' => $id]);

        $updPostDto = new UpdatePostDTO(
            $updPost->getTitle(),
            $updPost->getContent(),
            $updPost->getShortDesc(),
            $updPost->getCategory(),
            null,
            null
        );

        if (true === $this->authChecker->isGranted('ROLE_ADMIN')) {
            $form = $this->formFactory->create(UpdatePostType::class, $updPostDto)->handleRequest($request);

            if ($this->updatePostTypeHandler->handle($form, $updPost)) {
                return $responder(true, null, null);
            }
        } elseif (true === $this->authChecker->isGranted('ROLE_NATURALIST')) {
            $userPostId = $updPost->getAuthor()->getId();
            $uId        = $this->token->getToken()->getUser();
            $userId     = $uId->getId();

            if ($userId !== $userPostId) {
                throw new AccessDeniedException('Vous n\'ètes pas le propriétaire de cet
                article, vous ne pouvez pas le modifier');
            } else {
                $form = $this->formFactory->create(UpdatePostType::class, $updPostDto)->handleRequest($request);

                if ($this->updatePostTypeHandler->handle($form, $updPost)) {
                    return $responder(true, null, null);
                }
            }
        } else {
            throw new AccessDeniedException('Vous n\'ètes pas le propriétaire de cet
                article, vous ne pouvez pas le modifier');
        }

        return $responder(false, $form, $updPostDto);
    }
}
