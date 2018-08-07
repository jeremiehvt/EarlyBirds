<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 11/06/2018
 * Time: 22:00
 */

namespace App\Domain\Models;

use Ramsey\Uuid\Uuid;

/**
 * Class Contact
 * @package App\Domain\Models
 */
class Contact
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     */
    private $id;

    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $mail;

    /**
     * @var bool
     */
    private $marketing;

    /**
     * @var bool
     */
    private $response;

    /**
     * Contact constructor.
     * @param string $author
     * @param string $message
     * @param string $subject
     * @param string $mail
     * @param bool   $marketing
     * @param bool   $response
     *
     * @throws \Exception
     */
    public function __construct(
        string $author,
        string $message,
        string $subject,
        string $mail,
        bool   $marketing,
        bool   $response
    ) {
        $this->id        = Uuid::uuid4();
        $this->author    = $author;
        $this->message   = $message;
        $this->subject   = $subject;
        $this->mail      = $mail;
        $this->marketing = $marketing;
        $this->response  = $response;
    }

    /**
     * @return \Ramsey\Uuid\UuidInterface
     */
    public function getId(): \Ramsey\Uuid\UuidInterface
    {
        return $this->id;
    }

    /**
     * @param \Ramsey\Uuid\UuidInterface $id
     */
    public function setId(\Ramsey\Uuid\UuidInterface $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     *
     * @return Contact
     */
    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return Contact
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     *
     * @return Contact
     */
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     *
     * @return Contact
     */
    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @return bool
     */
    public function isMarketing(): bool
    {
        return $this->marketing;
    }

    /**
     * @param bool $marketing
     *
     * @return self
     */
    public function setMarketing(bool $marketing): self
    {
        $this->marketing = $marketing;

        return $this;
    }

    /**
     * @return bool
     */
    public function isResponse(): bool
    {
        return $this->response;
    }

    /**
     * @param bool $response
     *
     * @return self
     */
    public function setResponse(bool $response): self
    {
        $this->response = $response;

        return $this;
    }

}
