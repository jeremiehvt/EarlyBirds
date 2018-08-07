<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 16/07/2018
 * Time: 21:37
 */

namespace App\Domain\DTO;

use App\Domain\DTO\Interfaces\UpdateObserveDTOInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UpdateObserveDTO
 * @package App\Domain\DTO
 */
class UpdateObserveDTO implements UpdateObserveDTOInterface
{
    /**
     * @var null
     */
    public $ref;

    /**
     * @Assert\NotBlank(message="la description doit être complétée")
     * @Assert\Length(
     *      min = 5,
     *      max = 5000,
     *      minMessage = "votre description doit contenir au moins {{ limit }} carctères",
     *      maxMessage = "votre description doit contenir moins de {{ limit }} carctères"
     * )
     * @var string
     */
    public $description;

    /**
     * @Assert\NotBlank(message="la latitude ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "votre latitude doit contenir au moins {{ limit }} carctères"
     * )
     *
     * @var string
     */
    public $latitude;

    /**
     * @Assert\NotBlank(message="la longitude ne peut pas être vide")
     * @Assert\Length(
     *      min = 1,
     *      minMessage = "votre longitude doit contenir au moins {{ limit }} carctères"
     * )
     * @var string
     */
    public $longitude;

    /**
     * @Assert\Date()
     * @Assert\LessThanOrEqual("today", message="la date doit être égale ou inférieur à
     aujourd'hui")
     * @var \DateTime
     */
    public $obsDate;

    /**
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypes = {"image/jpeg", "image/png"},
     *     maxSizeMessage = "votre image doit être inférieur à {{ limit }} {{ suffix }}",
     *     mimeTypesMessage = "votre image doit être de type jpeg ou png"
     * )
     * @var UploadedFile
     */
    public $img;

    /**
     * ObserveDTO constructor.
     *
     * @param null|string       $ref
     * @param null|string       $description
     * @param null|string       $latitude
     * @param null|string       $longitude
     * @param \DateTime|null    $date
     * @param UploadedFile|null $img
     */
    public function __construct(
        $ref = null,
        string       $description = null,
        string       $latitude = null,
        string       $longitude = null,
        \DateTime    $date = null,
        UploadedFile $img = null
    ) {
        $this->ref          = $ref;
        $this->description  = $description;
        $this->latitude     = $latitude;
        $this->longitude    = $longitude;
        $this->obsDate      = $date;
        $this->img          = $img;
    }

    /**
     * @return null|string
     */
    public function getRef(): ?string
    {
        return $this->ref;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getlatitude(): string
    {
        return $this->latitude;
    }

    /**
     * @return string
     */
    public function getLongitude(): string
    {
        return $this->longitude;
    }

    /**
     * @return \DateTime
     */
    public function getObsDate(): \DateTime
    {
        return $this->obsDate;
    }

    /**
     * @return null|UploadedFile
     */
    public function getImg(): ?UploadedFile
    {
        return $this->img;
    }
}