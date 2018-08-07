<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 18/07/2018
 * Time: 22:01
 */

namespace App\UI\Responder\Interfaces;


use Symfony\Component\Form\FormInterface;

interface AddPostResponderInterface
{

    public function __invoke(bool $redirect, FormInterface $form);
}