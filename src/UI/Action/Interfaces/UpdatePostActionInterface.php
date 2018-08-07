<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 19/07/2018
 * Time: 10:49
 */

namespace App\UI\Action\Interfaces;


use Symfony\Component\HttpFoundation\Request;

interface UpdatePostActionInterface
{
    public function __invoke(Request $resquest);
}