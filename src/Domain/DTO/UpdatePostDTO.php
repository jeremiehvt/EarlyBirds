<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 18/07/2018
 * Time: 11:01
 */

namespace App\Domain\DTO;

use App\Domain\DTO\Interfaces\UpdatePostDTOInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as AcmeAssert;

class UpdatePostDTO implements UpdatePostDTOInterface
{
    /**
     * @Assert\NotBlank(message="le titre doit être complété")
     * @Assert\Length(
     *      min = 5,
     *      max = 100,
     *      minMessage = "votre titre doit contenir au moins {{ limit }} carctères",
     *      maxMessage = "votre titre doit contenir moins de {{ limit }} carctères"
     * )
     * @var string
     */
    public $title;

    /**
     * @Assert\NotBlank(message="l'article doit être complété")
     * @AcmeAssert\ExistPostContent
     * @var string
     */
    public $content;

    /**
     * @Assert\NotBlank(message="une catégorie doit être sélectionnée")
     * @var string
     */
    public $category;

    /**
     * @Assert\NotBlank(message="la description doit être complété")
     * @Assert\Length(
     *      min = 130,
     *      max = 320,
     *      minMessage = "votre description doit contenir au moins {{ limit }} carctères",
     *      maxMessage = "votre description doit contenir moins de {{ limit }} carctères"
     * )
     * @var string
     */
    public $shortDesc;

    /**
     *
     *  @Assert\File(
     *     maxSize = "1M",
     *     mimeTypes = {"image/jpeg", "image/png"},
     *     maxSizeMessage = "votre image doit être inférieur à {{ limit }} {{ suffix }}",
     *     mimeTypesMessage = "votre image doit être de type jpeg ou png"
     * )
     * @var UploadedFile
     */
    public $img;

    /**
     *  @Assert\File(
     *     maxSize = "1M",
     *     mimeTypes = {"image/jpeg", "image/png"},
     *     maxSizeMessage = "votre image doit être inférieur à {{ limit }} {{ suffix }}",
     *     mimeTypesMessage = "votre image doit être de type jpeg ou png"
     * )
     * @var UploadedFile
     */
    public $miniature;

    /**
     * AddPostDTO constructor.
     * @param null|string       $title
     * @param null|string       $content
     * @param null|string       $shortDesc
     * @param null|string       $category
     * @param null|UploadedFile $img
     * @param null|UploadedFile $miniature
     */
    public function __construct(
        string       $title = null,
        string       $content = null,
        string       $shortDesc = null,
        string       $category = null,
        UploadedFile $img = null,
        UploadedFile $miniature = null

    ) {
        $this->title     = $title;
        $this->content   = $content;
        $this->shortDesc = $shortDesc;
        $this->category  = $category;
        $this->img       = $img;
        $this->miniature = $miniature;
    }
}