<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 18/07/2018
 * Time: 19:12
 */

namespace App\UI\Form\Handler;

use App\Domain\Builder\Interfaces\CommentBuilderInterface;
use App\Domain\Models\Post;
use App\Domain\Models\User;
use App\Domain\Repository\CommentRepository;
use App\UI\Form\Handler\Interfaces\CommentTypeHandlerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CommentTypeHandler implements CommentTypeHandlerInterface
{
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * @var CommentBuilderInterface
     */
    private $commentBuilder;

    /**
     * @var FlashBagInterface
     */
    private $flash;

    /**
     * @var TokenStorageInterface
     */
    private $token;

    /**
     * CommentTypeHandler constructor.
     * @param CommentRepository       $commentRepository
     * @param CommentBuilderInterface $commentBuilder
     * @param FlashBagInterface       $flash
     * @param TokenStorageInterface   $token
     */
    public function __construct(
        CommentRepository $commentRepository,
        CommentBuilderInterface $commentBuilder,
        FlashBagInterface $flash,
        TokenStorageInterface $token
    ) {
        $this->commentRepository = $commentRepository;
        $this->commentBuilder    = $commentBuilder;
        $this->flash             = $flash;
        $this->token             = $token;
    }

    /**
     * @param FormInterface $form
     * @param Post          $post
     *
     * @return bool
     */
    public function handle(FormInterface $form, Post $post = null): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $this->token->getToken()->getUser();
            $this->commentBuilder->create(
                $user,
                $form->getData()->content
            );

            $comment = $this->commentBuilder->getComment();
            $comment->setPost($post);

            $this->commentRepository->save($comment);

            return true;
        }

        return false;
    }
}