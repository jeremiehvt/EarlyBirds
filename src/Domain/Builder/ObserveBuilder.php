<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 04/06/2018
 * Time: 21:10
 */

namespace App\Domain\Builder;

use App\Domain\Builder\Interfaces\ObserveBuilderInterface;
use App\Domain\Models\Observe;
use App\Domain\Models\User;

/**
 * Class ObserveBuilder
 * @package App\Domain\Builder
 */
class ObserveBuilder implements ObserveBuilderInterface
{
    /**
     * @var Observe
     */
    private $observe;

    /**
     * {@inheritdoc}
     */
    public function create(
        User      $author,
                  $ref,
        string    $description,
        string    $latitude,
        string    $longitude,
        \DateTime $date,
        string    $img
    ): ObserveBuilderInterface {
       $this->observe = new Observe(
           $author,
           $ref,
           $description,
           $latitude,
           $longitude,
           $date,
           $img
       );

       return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getObserve(): Observe
    {
        return $this->observe;
    }
}
