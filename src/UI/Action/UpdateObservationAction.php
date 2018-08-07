<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 14/06/2018
 * Time: 13:52
 */

namespace App\UI\Action;

use App\Domain\DTO\UpdateObserveDTO;
use App\Domain\Repository\ObserveRepository;
use App\UI\Action\Interfaces\UpdateObservationActionInterface;
use App\UI\Form\Handler\Interfaces\UpdateObserveTypeHandlerInterface;
use App\UI\Form\UpdateObserveType;
use App\UI\Responder\Interfaces\UpdateObservationResponderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class UpdateObservationAction
 * @package App\UI\Action
 * @Route(
 *     "/modifier-lobservation-{id}",
 *     name="modifyobserve",
 *     methods={"GET", "POST"}
 * )
 */
final class UpdateObservationAction implements UpdateObservationActionInterface
{
    /**
     * @var UpdateObserveTypeHandlerInterface
     */
    private $updateObserveTypeHandler;

    /**
     * @var ObserveRepository
     */
    private $observeRepository;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var TokenStorageInterface
     */
    private $token;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authChecker;

    /**
     * UpdateObservationAction constructor.
     *
     * @param UpdateObserveTypeHandlerInterface $updateObserveTypeHandler
     * @param ObserveRepository                 $observeRepository
     * @param FormFactoryInterface              $formFactory
     * @param TokenStorageInterface             $token
     * @param AuthorizationCheckerInterface     $authChecker
     */
    public function __construct(
        UpdateObserveTypeHandlerInterface $updateObserveTypeHandler,
        ObserveRepository                 $observeRepository,
        FormFactoryInterface              $formFactory,
        TokenStorageInterface             $token,
        AuthorizationCheckerInterface     $authChecker
    )
    {
        $this->updateObserveTypeHandler = $updateObserveTypeHandler;
        $this->observeRepository        = $observeRepository;
        $this->formFactory              = $formFactory;
        $this->token                    = $token;
        $this->authChecker              = $authChecker;
    }

    /**
     * @param Request                             $request
     * @param UpdateObservationResponderInterface $updateObservationResponder
     * @param string                              $id
     *
     * @return mixed
     */
    public function __invoke(
        Request                             $request,
        UpdateObservationResponderInterface $updateObservationResponder,
        string                              $id
    ) {

        $observe = $this->observeRepository->findOneBy(['id' => $id]);
        $ref = $observe->getRef();

        if (true === $this->authChecker->isGranted('ROLE_USER')) {
            $userObsId = $observe->getAuthor()->getId();
            $uId = $this->token->getToken()->getUser();
            $userId = $uId->getId();

            if ($userId !== $userObsId) {
                throw new AccessDeniedException('Vous n\'ètes pas le propriétaire de cette 
            observation, vous ne pouvez pas la modifié');
            }
        } else {
            throw new AccessDeniedException('Vous n\'ètes pas le propriétaire de cette 
            observation, vous ne pouvez pas la modifié');
        }

        if ($ref == null) {
            $observeDTO = new UpdateObserveDTO(
                $ref,
                $observe->getDescription(),
                $observe->getLatitude(),
                $observe->getLongitude(),
                $observe->getObsDate(),
                null
            );
        } else {
            $observeDTO = new UpdateObserveDTO(
                $observe->getRef()->getNomComplet(),
                $observe->getDescription(),
                $observe->getLatitude(),
                $observe->getLongitude(),
                $observe->getObsDate(),
                null
            );
        }

        $updateObserve = $this->formFactory
            ->create(UpdateObserveType::class, $observeDTO)
            ->handleRequest($request);

        if ($this->updateObserveTypeHandler->handle($updateObserve, $observe)) {
            return $updateObservationResponder(
                true,
                null,
                null,
                $updateObserve
            );
        }

        return $updateObservationResponder(
            false,
            $observeDTO,
            $observe->getImg(),
            $updateObserve
        );
    }
}
