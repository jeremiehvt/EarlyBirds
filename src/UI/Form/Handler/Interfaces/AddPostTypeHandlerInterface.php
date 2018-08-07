<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 18/07/2018
 * Time: 18:15
 */

namespace App\UI\Form\Handler\Interfaces;

use Symfony\Component\Form\FormInterface;

interface AddPostTypeHandlerInterface
{
    public function handle(FormInterface $form): bool;
}