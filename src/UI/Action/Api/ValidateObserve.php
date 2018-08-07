<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 25/06/2018
 * Time: 14:07
 */

namespace App\UI\Action\Api;

use App\Domain\Repository\ObserveRepository;
use App\Domain\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class ValidateObserve
 * @Route(
 *     "/validate-observe/{id}",
 *     name="validate_observe",
 *     methods={"POST"}
 * )
 * @IsGranted("ROLE_NATURALIST")
 */
class ValidateObserve
{
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
     * DeleteObserve constructor.
     * @param UserRepository        $userRepository
     * @param ObserveRepository     $observeRepository
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(
        UserRepository $userRepository,
        ObserveRepository $observeRepository,
        TokenStorageInterface $tokenStorage
    ) {
        $this->observeRepository = $observeRepository;
        $this->tokenStorage      = $tokenStorage;
        $this->userRepository    = $userRepository;
    }

    /**
     * @param observeId $id
     *
     * @return JsonResponse
     */
    public function __invoke($id)
    {
        $currentUser = $this->tokenStorage->getToken()->getUser();
        $observe     = $this->observeRepository->findOneBy(['id' => $id]);

        $author = $observe->getAuthor();
        $author->setScore($author->getScore() + 30);
        $this->userRepository->update();

        $observe->setValidator($currentUser);
        $this->observeRepository->update();

        return new JsonResponse(true);
    }

}