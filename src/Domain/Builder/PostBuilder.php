<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 18/07/2018
 * Time: 13:33
 */

namespace App\Domain\Builder;


use App\Domain\Builder\Interfaces\PostBuilderInterface;
use App\Domain\Models\Post;
use App\Domain\Models\User;

class PostBuilder implements PostBuilderInterface
{
    /**
     * @var Post
     */
    private $post;

    /**
     * @param string      $title
     * @param string      $content
     * @param string      $shortDesc
     * @param User        $author
     * @param string      $category
     * @param string      $img
     * @param null|string $miniature
     * @return mixed|void
     * @throws \Exception
     */
    public function create(
        string $title,
        string $content,
        string $shortDesc,
        User   $author,
        string $category,
        string $img,
               $miniature
    ) {
        $this->post = new Post(
            $title,
            $content,
            $shortDesc,
            $author,
            $category,
            $img,
            $miniature
        );
    }

    public function getPost(): Post
    {
        return $this->post;
    }

}