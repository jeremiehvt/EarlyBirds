<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 18/07/2018
 * Time: 13:42
 */

namespace App\Domain\Builder;

use App\Domain\Builder\Interfaces\CommentBuilderInterface;
use App\Domain\Models\Comment;
use App\Domain\Models\User;

class CommentBuilder implements CommentBuilderInterface
{
    /**
     * @var Comment
     */
    private $comment;

    /**
     * @param User   $author
     * @param string $content
     * @return mixed|void
     */
    public function create(
        User   $author,
        string $content
    ) {
        $this->comment = new Comment(
           $content,
           $author
        );
    }

    /**
     * @return Comment
     */
    public function getComment(): Comment
    {
        return $this->comment;
    }


}