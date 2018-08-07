<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 18/07/2018
 * Time: 21:59
 */

namespace App\UI\Action;

use App\UI\Action\Interfaces\AddPostActionInterface;
use App\UI\Form\AddPostType;
use App\UI\Form\Handler\Interfaces\AddPostTypeHandlerInterface;
use App\UI\Responder\Interfaces\AddPostResponderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(
 *     path="/saisir-article",
 *     name="app_add_post",
 *     methods={"GET","POST"}
 * )
 * Class AddPostAction
 * @package App\UI\Action
 */
class AddPostAction implements AddPostActionInterface
{
    /**
     * @var AddPostResponderInterface
     */
    private $addPostResponder;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var AddPostTypeHandlerInterface
     */
    private $addPostTypeHandler;

    /**
     * AddPostAction constructor.
     * @param AddPostResponderInterface   $addPostResponder
     * @param FormFactoryInterface        $formFactory
     * @param AddPostTypeHandlerInterface $addPostTypeHandler
     */
    public function __construct(
        AddPostResponderInterface   $addPostResponder,
        FormFactoryInterface        $formFactory,
        AddPostTypeHandlerInterface $addPostTypeHandler
    ) {
        $this->addPostResponder   = $addPostResponder;
        $this->formFactory        = $formFactory;
        $this->addPostTypeHandler = $addPostTypeHandler;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $responder = $this->addPostResponder;

        $postForm = $this->formFactory->create(AddPostType::class)->handleRequest($request);

        if ($this->addPostTypeHandler->handle($postForm)) {

            return $responder(true, null);
        }
        return $responder(false, $postForm);
    }
}
