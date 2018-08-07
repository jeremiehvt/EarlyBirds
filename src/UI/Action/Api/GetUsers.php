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
 *     "/getusers",
 *     name="getusers",
 *     methods={"POST"}
 * )
 * @IsGranted("ROLE_ADMIN")
 */
class GetUsers
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
     * @return JsonResponse
     */
    public function __invoke()
    {
        $users = $this->userRepository->findAll();

        $autocomplete = [];
        foreach ($users as $user) {
            $mail = $user->getEmail();
            if ($user->getImg()) {
                $img = $user->getImg();
            } else {
                $img = null;
            }
            $autocomplete[$mail] = $img;
        }

        return new JsonResponse($autocomplete);
    }

}