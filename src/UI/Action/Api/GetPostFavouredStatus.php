<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 21/07/2018
 * Time: 09:41
 */

namespace App\UI\Action\Api;

use App\Domain\Models\Post;
use App\Domain\Models\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class GetPostFoufouredStatus
 * @Route(
 *     "/getfavoured",
 *     name="get_favoured",
 *     methods={"GET"}
 * )
 */
class GetPostFavouredStatus
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authChecker;

    /**
     * GetPostFavouredStatus constructor.
     *
     * @param TokenStorageInterface         $tokenStorage
     * @param AuthorizationCheckerInterface $authChecker
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        AuthorizationCheckerInterface $authChecker
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->authChecker  = $authChecker;
    }

    /**
     * @return JsonResponse
     */
    public function __invoke()
    {
        $currentUser = $this->tokenStorage->getToken()->getUser();

        $status = [];

        if (!$this->authChecker->isGranted("ROLE_USER")) {
            return new JsonResponse($status);
        } else {
            /** @var User $currentUser */
            $favoured = $currentUser->getFavoured()->getValues();


            /** @var Post $fav */
            foreach ($favoured as $fav) {
                array_push($status, $fav->getId());
            }

            return new JsonResponse($status);
        }
    }
}
