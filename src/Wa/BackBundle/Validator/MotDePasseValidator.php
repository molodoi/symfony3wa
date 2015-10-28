<?php

namespace Wa\BackBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MotDePasseValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        // $value c'est la valeur du mot de passe
        // $constraint c'est l'objet MotDePasse

        if (strlen($value) < $constraint->min)
        {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ nb }}', $constraint->min)
                ->addViolation();
        }
    }
}
