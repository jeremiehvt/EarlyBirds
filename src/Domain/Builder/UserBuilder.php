<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 07/05/2018
 * Time: 23:57
 */

namespace App\Domain\Builder;

use App\Domain\Builder\Interfaces\UserBuilderInterface;
use App\Domain\Models\User;

class UserBuilder implements UserBuilderInterface
{
    /**
     * @var User
     */
    private $user;

    /**
     * @param string   $email
     * @param string   $password
     * @param callable $passwordEncoder
     * @param int      $score
     *
     * @return UserBuilder
     */
    public function createFromRegistration(
        string $email,
        string $password,
        callable $passwordEncoder,
        int $score
    ):self {
        $this->user = new User(
            $email,
            $password,
            $passwordEncoder,
            ['ROLE_USER'],
            null,
            null,
            null,
            null,
            null,
            100,
            null
        );

        return $this;
    }

    /**
     * @param string   $email
     * @param string   $googleId
     * @param string   $password
     * @param callable $passwordEncoder
     * @param string   $nickname
     * @param string   $firstname
     * @param string   $lastname
     * @param string   $img
     * @param int      $score
     *
     * @return UserBuilder
     */
    public function createFromSocial(
        string $email,
        string $googleId,
        ?string $password,
        callable $passwordEncoder,
        string $nickname,
        string $firstname,
        string $lastname,
        string $img,
        int $score
    ): self {
        $this->user = new User(
            $email,
            null,
            $passwordEncoder,
            ['ROLE_USER'],
            $googleId,
            $nickname,
            $firstname,
            $lastname,
            $img,
            100,
            null
        );

        return $this;
    }

    /**
     * @param string   $email
     * @param string   $password
     * @param callable $passwordEncoder
     *
     * @return UserBuilder
     */
    public function modifyPassword(
        string $email,
        string $password,
        callable $passwordEncoder
    ):self {
        $this->user = new User(
            $email,
            $password,
            $passwordEncoder,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null
        );

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
