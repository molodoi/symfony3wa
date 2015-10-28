<?php

namespace Wa\BackBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class MotDePasse extends Constraint
{
    public $min = 6;
    public $message = "Le mot de passe doit comporter au minimum {{ nb }} caractères";
}