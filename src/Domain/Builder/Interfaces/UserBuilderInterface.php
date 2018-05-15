<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 08/05/2018
 * Time: 00:03
 */

namespace App\Domain\Builder\Interfaces;

use App\Domain\Models\User;

interface UserBuilderInterface
{
    /**
     * @param string   $email
     * @param string   $password
     * @param callable $passwordEncoder
     *
     * @return mixed
     */
    public function createFromRegistration(
        string $email,
        string $password,
        callable $passwordEncoder
    );

    public function createFromGoogle(
        string $email,
        string $googleId,
        string $nickname,
        string $firstname,
        string $lastname,
        string $img
    );

    /**
     * @return User
     */
    public function getUser();
}
