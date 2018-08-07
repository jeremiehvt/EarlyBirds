<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 17/07/2018
 * Time: 19:00
 */

namespace App\UI\Responder\Interfaces;

interface DiscoverBirdsResponderInterface
{
    /**
     * @param array $observes
     *
     * @return mixed
     */
    public function __invoke(array $observes);
}
