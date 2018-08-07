<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 11/06/2018
 * Time: 21:33
 */

namespace App\UI\Action;

use App\UI\Action\Interfaces\ContactActionInterface;
use App\UI\Form\ContactType;
use App\UI\Form\Handler\Interfaces\ContactTypeHandlerInterface;
use App\UI\Responder\Interfaces\ContactResponderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContactAction
 * @package App\UI\Action
 * @Route(
 *     "/contact",
 *     name="app_contact",
 *     methods={"GET","POST"}
 * )
 */
class ContactAction implements ContactActionInterface
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var ContactTypeHandlerInterface
     */
    private $contactTypeHandler;


    /**
     * ContactAction constructor.
     *
     * @param FormFactoryInterface        $formFactory
     * @param ContactTypeHandlerInterface $contactTypeHandler
     */
    public function __construct(
        FormFactoryInterface        $formFactory,
        ContactTypeHandlerInterface $contactTypeHandler
    ) {
        $this->formFactory        = $formFactory;
        $this->contactTypeHandler = $contactTypeHandler;
    }

    /**
     * @param ContactResponderInterface $contactResponder
     * @param Request $request
     * @return mixed
     */
    public function __invoke(ContactResponderInterface $contactResponder, Request $request)
    {
        $addContactType = $this->formFactory
                               ->create(ContactType::class)
                               ->handleRequest($request);

        if ($this->contactTypeHandler->handle($addContactType)) {

            return $contactResponder(true, null);
        }
        return $contactResponder(false, $addContactType);
    }
}
