<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 18/07/2018
 * Time: 13:33
 */

namespace App\Domain\Builder\Interfaces;


use App\Domain\Models\Post;
use App\Domain\Models\User;

/**
 * Interface PostBuilderInterface
 * @package App\Domain\Builder\Interfaces
 */
interface PostBuilderInterface
{
    /**
     * @param string $title
     * @param string $content
     * @param User   $author
     * @param string $category
     * @param string $img
     * @param string $miniature
     * @return mixed
     */
    public function create(
        string $title,
        string $content,
        User   $author,
        string $category,
        string $img,
        string $miniature
    );

    /**
     * @return Post
     */
    public function getPost(): Post;
}