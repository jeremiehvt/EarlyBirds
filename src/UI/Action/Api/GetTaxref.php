<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 01/06/2018
 * Time: 10:53
 */

namespace App\UI\Action\Api;

use App\Domain\Repository\TaxRefRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaxrefAction
 * @Route(
 *     "/taxref/{id}",
 *     name="taxref",
 *     methods={"GET", "POST"}
 *     )
 */
class GetTaxref
{
    /**
     * @var TaxRefRepository
     */
    private $taxRefRepository;

    /**
     * TaxrefAction constructor.
     * @param TaxRefRepository $taxRefRepository
     */
    public function __construct(TaxRefRepository $taxRefRepository)
    {
        $this->taxRefRepository = $taxRefRepository;
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function __invoke($id)
    {
        $taxref = $this->taxRefRepository->findByIdToArray($id);

        return JsonResponse::create($taxref[0]);
    }
}
