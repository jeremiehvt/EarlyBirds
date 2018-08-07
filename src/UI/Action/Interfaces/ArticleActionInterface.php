<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 18/07/2018
 * Time: 15:54
 */

namespace App\UI\Action\Interfaces;


use Symfony\Component\HttpFoundation\Request;

interface ArticleActionInterface
{
    public function __invoke(Request $request);
}