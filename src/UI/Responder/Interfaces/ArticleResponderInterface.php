<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 18/07/2018
 * Time: 15:53
 */

namespace App\UI\Responder\Interfaces;

use App\Domain\Models\Post;
use Symfony\Component\Form\FormInterface;

interface ArticleResponderInterface
{
    public function __invoke(bool $redirect = false, Post $post, FormInterface $form = null);
}