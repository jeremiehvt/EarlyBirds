<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 06/05/2018
 * Time: 20:31
 */

namespace App\Domain\DTO;

use App\Domain\DTO\Interfaces\RegisterDTOInterface;

class RegisterDTO implements RegisterDTOInterface
{
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $password;

    /**
     * RegisterDTO constructor.
     * @param string      $email
     * @param null|string $password
     */
    public function __construct(
        string $email,
        ?string $password
    ) {
        $this->email    = $email;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
