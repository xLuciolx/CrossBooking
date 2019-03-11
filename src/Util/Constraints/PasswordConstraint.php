<?php

namespace App\Util\Constraints;

use Symfony\Component\Validator\Constraint;

/**
* @Annotation
*/
class PasswordConstraint extends Constraint{
    /*message when constraint failed*/
    public $message = 'Veuillez saisir 6 caractères minimum dont au moins un chiffre et une majuscule';
    public function validateBy()
    {
        return PasswordConstraintValidator::class;
    }
}