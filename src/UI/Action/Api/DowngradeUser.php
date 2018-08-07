<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 26/06/2018
 * Time: 00:01
 */

namespace App\UI\Action\Api;

use App\Domain\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DowngradeUser
 * @Route(
 *     "/downgradeuser/{id}",
 *     name="downgrade_user",
 *     methods={"POST"}
 * )
 * @IsGranted("ROLE_ADMIN")
 */
class DowngradeUser
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
     */
    public function __invoke($id)
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);

        if (in_array("ROLE_ADMIN", $user->getRoles())) {
            $user = $user->removeRoles();
            $this->userRepository->update();
            $user->addRole("ROLE_USER");
            $user->addRole("ROLE_NATURALIST");
        } else {
            $user = $user->removeRoles();
            $user->addRole("ROLE_USER");
        }

        $status = $this->userRepository->update();

        return new JsonResponse($status);
    }
}
