<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 18/07/2018
 * Time: 10:05
 */

namespace App\UI\Responder\Interfaces;

use App\Domain\Models\Observe;

interface ViewObserveResponderInterface
{
    /**
     * @param Observe $observe
     * @param string  $referer
     *
     * @return mixed
     */
    public function __invoke(Observe $observe, string $referer);
}
