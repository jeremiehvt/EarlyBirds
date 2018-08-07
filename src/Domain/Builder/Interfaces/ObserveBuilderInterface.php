<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 04/06/2018
 * Time: 21:10
 */

namespace App\Domain\Builder\Interfaces;


use App\Domain\Models\Observe;
use App\Domain\Models\TaxRef;
use App\Domain\Models\User;

/**
 * Interface ObserveBuilderInterface
 * @package App\Domain\Builder\Interfaces
 */
interface ObserveBuilderInterface
{
    /**
     * @param User           $author
     * @param null|TaxRef    $ref
     * @param string         $description
     * @param string         $latitude
     * @param string         $longitude
     * @param \DateTime      $date
     * @param string         $img
     *
     * @return ObserveBuilderInterface
     */
    public function create(
        User      $author,
                  $ref,
        string    $description,
        string    $latitude,
        string    $longitude,
        \DateTime $date,
        string    $img
    ):self;

    /**
     * @return Observe
     */
    public function getObserve(): Observe;
}
