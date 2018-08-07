<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 06/05/2018
 * Time: 00:31
 */

namespace App\UI\Action;

use App\UI\Action\Interfaces\ObservationActionInterface;
use App\UI\Form\Handler\Interfaces\ObserveTypeHandlerInterface;
use App\UI\Form\ObserveType;
use App\UI\Responder\Interfaces\ObservationResponderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ObservationAction
 * @Route(
 *     "/saisir-observation",
 *     name="app_observe",
 *     methods={"GET","POST"}
 * )
 */
final class ObservationAction implements ObservationActionInterface
{
    /**
     * @var ObserveTypeHandlerInterface
     */
    private $observationTypeHandler;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * ObservationAction constructor.
     * @param ObserveTypeHandlerInterface $observationTypeHandler
     * @param FormFactoryInterface        $formFactory
     */
    public function __construct(
        ObserveTypeHandlerInterface $observationTypeHandler,
        FormFactoryInterface        $formFactory
    ) {
        $this->observationTypeHandler = $observationTypeHandler;
        $this->formFactory            = $formFactory;
    }

    /**
     * @param Request                       $request
     * @param ObservationResponderInterface $responder
     *
     * @return mixed
     */
    public function __invoke(Request $request, ObservationResponderInterface $responder)
    {
        $addObservationType = $this->formFactory
            ->create(ObserveType::class)
            ->handleRequest($request);

        if ($this->observationTypeHandler->Handle($addObservationType)) {

            return $responder(true, null);

        }

        return $responder(false, $addObservationType);
    }
}
