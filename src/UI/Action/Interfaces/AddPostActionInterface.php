<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 18/07/2018
 * Time: 21:59
 */

namespace App\UI\Action\Interfaces;


use Symfony\Component\HttpFoundation\Request;

interface AddPostActionInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function __invoke(Request $request);
}