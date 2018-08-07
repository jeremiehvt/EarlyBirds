<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 18/07/2018
 * Time: 13:42
 */

namespace App\Domain\Builder\Interfaces;

use App\Domain\Models\Comment;
use App\Domain\Models\User;

interface CommentBuilderInterface
{
    /**
     * @param User   $author
     * @param string $content
     * @return mixed
     */
    public function create(
        User   $author,
        string $content
    );

    public function getComment(): Comment;
}