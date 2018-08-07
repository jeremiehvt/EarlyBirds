<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 10/05/2018
 * Time: 07:37
 */

namespace App\UI\Action;

use App\Domain\Repository\ObserveRepository;
use App\Domain\Repository\UserRepository;
use App\Services\Gamification;
use App\UI\Action\Interfaces\ProfileActionInterface;
use App\UI\Form\Handler\Interfaces\ProfileTypeHandlerInterface;
use App\UI\Form\ProfileType;
use App\UI\Responder\Interfaces\ProfileResponderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class ProfileAction
 * @Route(
 *     "/profil",
 *     name="app_profile",
 *     methods={"GET", "POST"}
 * )
 * @IsGranted("ROLE_USER")
 */
final class ProfileAction implements ProfileActionInterface
{
    /**
     * @var FormFactoryInterface
     */
    private $form;
    /**
     * @var ProfileTypeHandlerInterface
     */
    private $typeHandler;
    /**
     * @var ObserveRepository
     */
    private $observeRepository;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var Gamification
     */
    private $gamification;

    /**
     * ProfileAction constructor.
     * @param FormFactoryInterface        $form
     * @param ProfileTypeHandlerInterface $typeHandler
     * @param ObserveRepository           $observeRepository
     * @param TokenStorageInterface       $tokenStorage
     * @param UserRepository              $userRepository
     * @param Gamification                $gamification
     */
    public function __construct(
        FormFactoryInterface $form,
        ProfileTypeHandlerInterface $typeHandler,
        ObserveRepository $observeRepository,
        TokenStorageInterface $tokenStorage,
        UserRepository $userRepository,
        Gamification $gamification
    ) {
        $this->form              = $form;
        $this->typeHandler       = $typeHandler;
        $this->observeRepository = $observeRepository;
        $this->tokenStorage      = $tokenStorage;
        $this->userRepository    = $userRepository;
        $this->gamification      = $gamification;
    }
    /**
     * @param Request                   $request
     * @param ProfileResponderInterface $profileResponder
     *
     * @return mixed
     */
    public function __invoke(
        Request $request,
        ProfileResponderInterface $profileResponder
    ) {
        $user   = $this->tokenStorage->getToken()->getUser();
        $userId = $user->getId();

        $myObserves = $this->observeRepository->findMyObservationsByOrderDesc($userId);

        $observesToValidate = $this->observeRepository->findNonValidate();

        $users = $this->userRepository->findAll();

        $level = $this->gamification->getLevel($user);

        $profileType = $this->form->create(ProfileType::class)
            ->handleRequest($request);

        if ($this->typeHandler->handle($profileType)) {
            return $profileResponder(true);
        }

        return $profileResponder(false, $profileType, $myObserves, $observesToValidate, $users, $level);
    }
}
