<?php

namespace Wa\BackBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PositionCategory extends Constraint
{
    public $message = "La position existe déjà";

    public function validatedBy()
    {
        return 'troiswa_back_position_category';
    }
}