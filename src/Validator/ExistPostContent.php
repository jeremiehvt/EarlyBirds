<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 23/07/2018
 * Time: 16:03
 */

namespace App\Validator;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * Class ExistPostContent
 * @package App\Validator
 */
class ExistPostContent extends Constraint
{
    /**
     * @var string
     */
    public $message = 'l\'article doit contenir entre 300 et 15000 caractères. Le votre en contient {{ number }} ';

    /**
     * @return string
     */
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }

}