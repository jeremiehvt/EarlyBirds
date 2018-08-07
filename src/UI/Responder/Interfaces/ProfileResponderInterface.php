<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 10/05/2018
 * Time: 07:41
 */

namespace App\UI\Responder\Interfaces;

use Symfony\Component\Form\FormInterface;

interface ProfileResponderInterface
{
    /**
     * @param bool               $redirect
     * @param FormInterface|null $form
     * @param array|null         $observe
     * @param array|null         $observesToValidate
     * @param array|null         $users
     * @param array|null         $level
     *
     * @return mixed
     */
    public function __invoke(
        bool $redirect = false,
        FormInterface $form = null,
        array $observe = null,
        array $observesToValidate = null,
        array $users = null,
        array $level = null
    );
}
