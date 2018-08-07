<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 25/06/2018
 * Time: 21:36
 */

namespace App\UI\Action;

use App\UI\Action\Interfaces\FAQActionInterface;
use App\UI\Responder\Interfaces\FAQResponderInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FAQAction
 * @package App\UI\Action
 * @Route(
 *     path="/foire-aux-questions",
 *     name="app_faq",
 *     methods={"GET"}
 * )
 */
class FAQAction implements FAQActionInterface
{
    /**
     * @var FAQResponderInterface
     */
    private $faqResponder;

    /**
     * FAQAction constructor.
     * @param FAQResponderInterface $faqResponder
     */
    public function __construct(FAQResponderInterface $faqResponder)
    {
        $this->faqResponder = $faqResponder;
    }

    /**
     * @return mixed
     */
    public function __invoke()
    {
        $responder = $this->faqResponder;
        return $responder();
    }
}