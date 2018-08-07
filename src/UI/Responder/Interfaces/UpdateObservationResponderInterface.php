<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 14/06/2018
 * Time: 13:59
 */

namespace App\UI\Responder\Interfaces;

use App\Domain\DTO\Interfaces\UpdateObserveDTOInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Interface UpdateObservationResponderInterface
 * @package App\UI\Responder\Interfaces
 */
interface UpdateObservationResponderInterface
{
    /**
     * @param bool                           $redirect
     * @param FormInterface                  $form
     * @param UpdateObserveDTOInterface|null $observeDTO
     * @param string|null                    $observe
     *
     * @return mixed
     */
    public function __invoke(
        bool                      $redirect = false,
        UpdateObserveDTOInterface $observeDTO = null,
        string                    $observe = null,
        FormInterface             $form
    );
}
