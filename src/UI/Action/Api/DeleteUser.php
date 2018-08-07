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

/**
 * Class DeleteUser
 * @Route(
 *     "/deluser/{id}",
 *     name="delete_user",
 *     methods={"DELETE"}
 * )
 * @IsGranted("ROLE_ADMIN")
 */
class DeleteUser
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * DeleteUser constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param user Id $id
     *
     * @return JsonResponse
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke($id)
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);

        $status = $this->userRepository->remove($user);

        return new JsonResponse($status);
    }

}