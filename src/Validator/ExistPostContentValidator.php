<?php
/**
 * Created by PhpStorm.
 * User: havartjeremie
 * Date: 23/07/2018
 * Time: 16:04
 */

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class ExistPostContentValidator
 *
 * @package App\Validator
 */
class ExistPostContentValidator extends ConstraintValidator
{
    /**
     * @param mixed      $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {

        if (strlen($value) < 300) {
            $countValue = strlen($value);
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ number }}', $countValue)
                ->addViolation();
        } elseif (strlen($value) > 50000) {
            $countValue = strlen($value);
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ number }}', $countValue)
                ->addViolation();
        }
    }
}
