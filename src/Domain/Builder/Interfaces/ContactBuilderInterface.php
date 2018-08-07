<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 11/06/2018
 * Time: 22:23
 */

namespace App\Domain\Builder\Interfaces;

use App\Domain\Builder\ContactBuilder;
use App\Domain\Models\Contact;

/**
 * Interface ContactBuilderInterface
 * @package App\Domain\Builder\Interfaces
 */
interface ContactBuilderInterface
{
    public function create(
        string $author,
        string $message,
        string $subject,
        string $mail,
        bool   $response,
        bool   $market
    ): ContactBuilder;

    public function getContact(): Contact;
}
