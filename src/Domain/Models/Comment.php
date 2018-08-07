<?php

namespace App\Domain\Models;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="App\Domain\Repository\CommentRepository")
 */
class Comment
{
    use TimestampableEntity;
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var User
     */
    private $author;

    /**
     * @var string
     */
    private $content;

    /**
     * @var Post
     */
    private $post;

    /**
     * Comment constructor.
     * @param string $content
     * @param User $author
     *
     * @throws \Exception
     */
    public function __construct(string $content, User $author)
    {
        $this->id      = Uuid::uuid4();
        $this->content = $content;
        $this->author  = $author;
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * @param User|null $author
     * @return Comment
     */
    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }

    /**
     * @param Post $post
     * @return Comment
     */
    public function setPost(Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }




}
