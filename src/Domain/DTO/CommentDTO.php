<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 18/07/2018
 * Time: 11:27
 */

namespace App\Domain\DTO;

use App\Domain\DTO\Interfaces\CommentDTOInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CommentDTO
 *
 * @package App\Domain\DTO
 */
class CommentDTO implements CommentDTOInterface
{
    /**
     * @Assert\NotBlank(message="la description doit être complétée")
     * @Assert\Length(
     *      min = 2,
     *      max = 300,
     *      minMessage = "votre commentaire doit contenir au moins {{ limit }} carctères",
     *      maxMessage = "votre commentaire doit contenir moins de {{ limit }} carctères"
     * )
     * @var string
     */
    public $content;

    /**
     * CommentDTO constructor.
     * @param null|string $content
     */
    public function __construct(string $content = null)
    {
        $this->content = $content;
    }


}