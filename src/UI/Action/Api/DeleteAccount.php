<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 25/06/2018
 * Time: 14:07
 */

namespace App\UI\Action\Api;

use App\Domain\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class DeleteAccount
 * @Route(
 *     "/delaccount/",
 *     name="delete_account",
 *     methods={"DELETE"}
 * )
 * @IsGranted("ROLE_USER")
 */
class DeleteAccount
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * DeleteUser constructor.
     * @param UserRepository        $userRepository
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(
        UserRepository $userRepository,
        TokenStorageInterface $tokenStorage
    ) {
        $this->userRepository = $userRepository;
        $this->tokenStorage   = $tokenStorage;
    }

    /**
     * @return JsonResponse
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke()
    {
        $currentUser = $this->tokenStorage->getToken()->getUser();

        $status = $this->userRepository->remove($currentUser);

        return new JsonResponse($status);

//        return new RedirectResponse("/logout");
    }

}