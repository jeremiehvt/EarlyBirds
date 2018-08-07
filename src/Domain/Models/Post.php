<?php

namespace App\Domain\Models;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="App\Domain\Repository\PostRepository")
 */
class Post
{
    use TimestampableEntity;
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $shortDesc;

    /**
     * @var User
     */
    private $author;

    /**
     * @var string
     */
    private $category;

    /**
     * @var string
     */
    private $img;

    /**
     * @var string
     */
    private $miniature;

    /**
     * @var User
     */
    private $favouredBy;

    /**
     * @var Comment
     */
    private $postComments;

    /**
     * Post constructor.
     * @param string      $title
     * @param string      $content
     * @param string      $shortDesc
     * @param User        $author
     * @param string      $category
     * @param string      $img
     * @param null|string $miniature
     *
     * @throws \Exception
     */
    public function __construct(
        string $title,
        string $content,
        string $shortDesc,
        User   $author,
        string $category,
        string $img,
               $miniature
    ) {
        $this->id           = Uuid::uuid4();
        $this->favouredBy   = new ArrayCollection();
        $this->author       = $author;
        $this->title        = $title;
        $this->category     = $category;
        $this->content      = $content;
        $this->shortDesc    = $shortDesc;
        $this->img          = $img;
        $this->miniature    = $miniature;
        $this->postComments = new ArrayCollection();
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
     *
     * @return Post
     */
    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getFavouredBy(): Collection
    {
        return $this->favouredBy;
    }

    /**
     * @param User $favouredBy
     *
     * @return Post
     */
    public function addFavouredBy(User $favouredBy): self
    {
        if (!$this->favouredBy->contains($favouredBy)) {
            $this->favouredBy[] = $favouredBy;
            $favouredBy->addFavoured($this);
        }

        return $this;
    }

    /**
     * @param User $favouredBy
     *
     * @return Post
     */
    public function removeFavouredBy(User $favouredBy): self
    {
        if ($this->favouredBy->contains($favouredBy)) {
            $this->favouredBy->removeElement($favouredBy);
            $favouredBy->removeFavoured($this);
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getPostComments()
    {
        return $this->postComments;
    }

    /**
     * @param Comment $comment
     * @return $this
     */
    public function addPostComments(Comment $comment): self
    {
        if (!$this->postComments->contains($comment)) {
            $this->postComments[] = $comment;
            $comment->setPost($this);
        }
        return $this;
    }

    /**
     * @param Comment $comment
     * @return $this
     */
    public function removePostComments(Comment $comment) :self
    {
        if ($this->postComments->contains($comment)) {
            $this->postComments->removeElement($comment);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getImg(): ?string
    {
        return $this->img;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param string $title
     *
     * @return Post
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $content
     *
     * @return Post
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param string $category
     *
     * @return Post
     */
    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @param string $img
     *
     * @return Post
     */
    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return string
     */
    public function getMiniature(): ?string
    {
        return $this->miniature;
    }

    /**
     * @param string $miniature
     *
     * @return Post
     */
    public function setMiniature(string $miniature): self
    {
        $this->miniature = $miniature;

        return $this;
    }

    /**
     * @return string
     */
    public function getShortDesc(): string
    {
        return $this->shortDesc;
    }

    /**
     * @param string $shortDesc
     * @return $this
     */
    public function setShortDesc(string $shortDesc): self
    {
        $this->shortDesc = $shortDesc;
        return $this;
    }


}
