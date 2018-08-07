<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 11/06/2018
 * Time: 22:16
 */

namespace App\Domain\DTO\Interfaces;

/**
 * Interface ContactDTOInterface
 * @package App\Domain\DTO\Interfaces
 */
interface ContactDTOInterface
{
    /**
     * ContactDTOInterface constructor.
     *
     * @param string $subject
     * @param string $author
     * @param string $message
     * @param string $mail
     * @param bool   $response
     * @param bool   $marketing
     */
    public function __construct(
        string $subject,
        string $author,
        string $message,
        string $mail,
        bool   $response,
        bool   $marketing
    );
}