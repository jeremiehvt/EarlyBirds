<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 19/07/2018
 * Time: 14:53
 */

namespace App\UI\Action\Interfaces;


use Symfony\Component\HttpFoundation\Request;

interface DeletePostActionInterface
{
    public function __invoke(Request $request);
}