<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 19/07/2018
 * Time: 10:51
 */

namespace App\UI\Responder\Interfaces;

use App\Domain\DTO\Interfaces\UpdatePostDTOInterface;
use Symfony\Component\Form\FormInterface;

interface UpdatePostResponderInterface
{
    public function __invoke(
        bool $redirect = false,
        FormInterface $form = null ,
        UpdatePostDTOInterface $post = null
    );
}