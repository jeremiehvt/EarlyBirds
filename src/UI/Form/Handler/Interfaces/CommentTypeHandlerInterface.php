<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 18/07/2018
 * Time: 19:11
 */

namespace App\UI\Form\Handler\Interfaces;

use App\Domain\Models\Post;
use Symfony\Component\Form\FormInterface;

interface CommentTypeHandlerInterface
{
    public function handle(FormInterface $form, Post $post): bool;
}