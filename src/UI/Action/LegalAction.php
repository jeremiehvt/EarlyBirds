<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 25/06/2018
 * Time: 21:53
 */

namespace App\UI\Action;

use App\UI\Action\Interfaces\LegalActionInterface;
use App\UI\Responder\Interfaces\LegalResponderInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LegalAction
 * @package App\UI\Action
 * @Route(
 *     path="/mentions-legales",
 *     name="app_legal",
 *     methods={"GET"}
 * )
 */
class LegalAction implements LegalActionInterface
{
    /**
     * @var LegalResponderInterface
     */
    private $legalResponder;

    /**
     * LegalAction constructor.
     * @param LegalResponderInterface $legalResponder
     */
    public function __construct(LegalResponderInterface $legalResponder)
    {
        $this->legalResponder = $legalResponder;
    }

    /**
     * @return mixed
     */
    public function __invoke()
    {
        $responder = $this->legalResponder;
        return $responder();
    }
}
