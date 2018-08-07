<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 18/07/2018
 * Time: 16:58
 */

namespace App\UI\Action;

use App\Domain\Repository\PostRepository;
use App\UI\Action\Interfaces\ArticleActionInterface;
use App\UI\Form\CommentType;
use App\UI\Form\Handler\Interfaces\CommentTypeHandlerInterface;
use App\UI\Responder\Interfaces\ArticleResponderInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route(
 *     path="/article-{id}",
 *     name="app_read_article",
 *     methods={"GET", "POST"}
 *
 * )
 * Class ArticleAction
 * @package App\UI\Action
 */
class ArticleAction implements ArticleActionInterface
{
    /**
     * @var ArticleResponderInterface
     */
    private $articleResponder;

    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var CommentTypeHandlerInterface
     */
    private $commentTypeHandler;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authChecker;

    /**
     * ArticleAction constructor.
     * @param ArticleResponderInterface     $articleResponder
     * @param PostRepository                $postRepository
     * @param FormFactoryInterface          $formFactory
     * @param CommentTypeHandlerInterface   $commentTypeHandler
     * @param AuthorizationCheckerInterface $authChecker
     */
    public function __construct(
        ArticleResponderInterface     $articleResponder,
        PostRepository                $postRepository,
        FormFactoryInterface          $formFactory,
        CommentTypeHandlerInterface   $commentTypeHandler,
        AuthorizationCheckerInterface $authChecker
    ) {
        $this->articleResponder   = $articleResponder;
        $this->postRepository     = $postRepository;
        $this->formFactory        = $formFactory;
        $this->commentTypeHandler = $commentTypeHandler;
        $this->authChecker        = $authChecker;
    }


    public function __invoke(Request $request)
    {
        $id = $request->attributes->get('id');
        $post = $this->postRepository->find(['id' => $id]);
        $responder = $this->articleResponder;


        $commentForm = $this->formFactory->create(CommentType::class)->handleRequest($request);

        if ($this->commentTypeHandler->handle($commentForm, $post) ) {
            if ($this->authChecker->isGranted("ROLE_USER")) {
                return $responder(true, $post, null);
            } else {
                throw new AccessDeniedException('seul les membres connectés peuvent saisir un commentaire ');
            }
        }



        return $responder(false, $post, $commentForm);
    }
}
