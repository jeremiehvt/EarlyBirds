<?php

namespace App\Domain\Models;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Domain\Repository\UserRepository")
 */
class User implements UserInterface
{
    use TimestampableEntity;
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var string
     */
    private $nickname;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $googleId;

    /**
     * @var string
     */
    private $facebookId;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string|null
     */
    private $salt;

    /**
     * @var string|null
     */
    private $resetPasswordToken;

    /**
     * @var array
     */
    private $roles;

    /**
     * @var ArrayCollection
     */
    private $observes;

    /**
     * @var array
     */
    private $validatedObserve;

    /**
     * @var int
     */
    private $score;

    /**
     * @var Level
     */
    private $level;

    /**
     * @var string
     */
    private $img;

    /**
     * @var ArrayCollection
     */
    private $badges;

    /**
     * @var ArrayCollection
     */
    private $comments;

    /**
     * @var ArrayCollection
     */
    private $posts;

    /**
     * @var ArrayCollection
     */
    private $upvoted;

    /**
     * @var Post
     */
    private $favoured;

    /**
     * User constructor.
     * @param string      $email
     * @param string      $password
     * @param callable    $passwordEncoder
     * @param array|null  $roles
     * @param string      $googleId
     * @param string      $nickname
     * @param string      $firstname
     * @param string      $lastname
     * @param string      $img
     * @param int         $score
     * @param null|string $resetPasswordToken
     *
     * @throws \Exception
     */
    public function __construct(
        string $email,
        ?string $password,
        callable $passwordEncoder,
        ?array $roles,
        ?string $googleId,
        ?string $nickname,
        ?string $firstname,
        ?string $lastname,
        ?string $img,
        ?int    $score,
        ?string $resetPasswordToken
    ) {
        $this->id                 = Uuid::uuid4();
        $this->email              = $email;
        $this->password           = $passwordEncoder($password, null);
        $this->roles              = $roles;
        $this->googleId           = $googleId;
        $this->nickname           = $nickname;
        $this->firstname          = $firstname;
        $this->lastname           = $lastname;
        $this->img                = $img;
        $this->score              = $score;
        $this->resetPasswordToken = $resetPasswordToken;
        $this->observes           = new ArrayCollection();
        $this->badges             = new ArrayCollection();
        $this->comments           = new ArrayCollection();
        $this->posts              = new ArrayCollection();
        $this->upvoted            = new ArrayCollection();
        $this->favoured           = new ArrayCollection();
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->email = $username;
    }

    /**
     * @return string
     */
    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    /**
     * @param null|string $nickname
     */
    public function setNickname(?string $nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @return string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(?string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(?string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getGoogleId(): string
    {
        return $this->googleId;
    }

    /**
     * @param string $googleId
     */
    public function setGoogleId(string $googleId): void
    {
        $this->googleId = $googleId;
    }

    /**
     * @return string
     */
    public function getFacebookId(): string
    {
        return $this->facebookId;
    }

    /**
     * @param string $facebookId
     */
    public function setFacebookId(string $facebookId): void
    {
        $this->facebookId = $facebookId;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return null|string
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @param null|string $salt
     */
    public function setSalt(?string $salt): void
    {
        $this->salt = $salt;
    }

    /**
     * @return null|string
     */
    public function getResetPasswordToken(): ?string
    {
        return $this->resetPasswordToken;
    }

    /**
     * @param null|string $resetPasswordToken
     */
    public function setResetPasswordToken(?string $resetPasswordToken): void
    {
        $this->resetPasswordToken = $resetPasswordToken;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        if (empty($this->roles)) {
            return ['ROLE_USER'];
        }

        return $this->roles;
    }

    /**
     * @param string $roles
     */
    public function addRole(string $roles): void
    {
        $this->roles[] = $roles;
    }

    /**
     * @return User
     */
    public function removeRoles(): self
    {
        $this->roles = null;

        return $this;
    }

    /**
 * @return Collection|Observe[]
 */
    public function getObserves(): Collection
    {
        return $this->observes;
    }

    /**
     * @param Observe $obserf
     *
     * @return User
     */
    public function addObserf(Observe $obserf): self
    {
        if (!$this->observes->contains($obserf)) {
            $this->observes[] = $obserf;
            $obserf->setAuthor($this);
        }

        return $this;
    }

    /**
     * @param Observe $obserf
     *
     * @return User
     */
    public function removeObserf(Observe $obserf): self
    {
        if ($this->observes->contains($obserf)) {
            $this->observes->removeElement($obserf);
            // set the owning side to null (unless already changed)
            if ($obserf->getAuthor() === $this) {
                $obserf->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getValidatedObserve(): array
    {
        return $this->validatedObserve;
    }

    /**
     * @param array $validatedObserve
     */
    public function setValidatedObserve(array $validatedObserve): void
    {
        $this->validatedObserve = $validatedObserve;
    }

    /**
     * @return int|null
     */
    public function getScore(): ?int
    {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    /**
     * @return Level|null
     */
    public function getLevel(): ?Level
    {
        return $this->level;
    }

    /**
     * @param Level|null $level
     *
     * @return User
     */
    public function setLevel(?Level $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return Collection|Badge[]
     */
    public function getBadges(): Collection
    {
        return $this->badges;
    }

    /**
     * @param Badge $badge
     *
     * @return User
     */
    public function addBadge(Badge $badge): self
    {
        if (!$this->badges->contains($badge)) {
            $this->badges[] = $badge;
            $badge->addUser($this);
        }

        return $this;
    }

    /**
     * @param Badge $badge
     *
     * @return User
     */
    public function removeBadge(Badge $badge): self
    {
        if ($this->badges->contains($badge)) {
            $this->badges->removeElement($badge);
            $badge->removeUser($this);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getImg(): ?string
    {
        return $this->img;
    }

    /**
     * @param string $img
     */
    public function setImg(string $img): void
    {
        $this->img = $img;
    }

    /**
     * @return Collection|Observe[]
     */
    public function getUpvoted(): Collection
    {
        return $this->upvoted;
    }

    /**
     * @param Observe $upvoted
     *
     * @return User
     */
    public function addUpvoted(Observe $upvoted): self
    {
        if (!$this->upvoted->contains($upvoted)) {
            $this->upvoted[] = $upvoted;
            $upvoted->addUpvoter($this);
        }

        return $this;
    }

    /**
     * @param Observe $upvoted
     *
     * @return User
     */
    public function removeUpvoted(Observe $upvoted): self
    {
        if ($this->upvoted->contains($upvoted)) {
            $this->upvoted->removeElement($upvoted);
            $upvoted->removeUpvoter($this);
        }

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    /**
     * @param Post $post
     *
     * @return User
     */
    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setAuthor($this);
        }

        return $this;
    }

    /**
     * @param Post $post
     *
     * @return User
     */
    public function removePost(Post $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getAuthor() === $this) {
                $post->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @param Comment $comment
     *
     * @return User
     */
    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setAuthor($this);
        }

        return $this;
    }

    /**
     * @param Comment $comment
     *
     * @return User
     */
    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getFavoured(): Collection
    {
        return $this->favoured;
    }

    /**
     * @param Post $favoured
     *
     * @return User
     */
    public function addFavoured(Post $favoured): self
    {
        if (!$this->favoured->contains($favoured)) {
            $this->favoured[] = $favoured;
        }

        return $this;
    }

    /**
     * @param Post $favoured
     *
     * @return User
     */
    public function removeFavoured(Post $favoured): self
    {
        if ($this->favoured->contains($favoured)) {
            $this->favoured->removeElement($favoured);
        }

        return $this;
    }

    public function eraseCredentials(): void
    {
    }
}
