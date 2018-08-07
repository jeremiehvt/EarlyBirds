<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 14/06/2018
 * Time: 13:59
 */

namespace App\UI\Responder;

use App\Domain\DTO\Interfaces\UpdateObserveDTOInterface;
use App\UI\Responder\Interfaces\UpdateObservationResponderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class UpdateObservationResponder implements UpdateObservationResponderInterface
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGeneratorInterface;

    /**
     * UpdateObservationResponder constructor.
     *
     * @param Environment           $twig
     * @param UrlGeneratorInterface $urlGeneratorInterface
     */
    public function __construct(
        Environment           $twig,
        UrlGeneratorInterface $urlGeneratorInterface
    ) {
        $this->twig                  = $twig;
        $this->urlGeneratorInterface = $urlGeneratorInterface;
    }

    /**
     * @param bool                           $redirect
     * @param FormInterface                  $form
     * @param UpdateObserveDTOInterface|null $observeDTO
     * @param string|null                    $observe
     *
     * @return mixed|RedirectResponse|Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(
        bool                      $redirect = false,
        UpdateObserveDTOInterface $observeDTO = null,
        string                    $observe = null,
        FormInterface             $form
    ) {
        $redirect
            ? $response = new RedirectResponse($this->urlGeneratorInterface->generate('app_observe'))
            : $response = new Response($this->twig->render('updateObservation.html.twig', [
                'form'       => $form->createView(),
                'observeDTO' => $observeDTO,
                'img'        => $observe
            ]))
        ;

        return $response;
    }
}
