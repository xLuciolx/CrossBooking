<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

use App\Entity\Member;

class ResetForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        //create an email input type
        ->add('mail', EmailType::class, [
            'required'      =>  true,
            'label'         =>  false,
            'constraints'   =>  array(new NotBlank(array('message' => 'Vous n\'avez pas indiqué votre Email')), new Email(
                array(
                    'message' => 'Veuillez saisir une adresse mail valide',
                    'strict'  => true,
                    'checkMX' => true
                )
            )),
            'attr'          =>  [
                'class'     => 'form-control',
            ]
        ])
        //create a submit
        ->add('submit', SubmitType::class, ['label' => 'Envoyer'])

        ;
    }

}