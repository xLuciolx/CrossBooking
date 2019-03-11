<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

use App\Util\Constraints\PasswordConstraint;
use App\Entity\Member;


class ResetForm2 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('mail', EmailType::class, [
            'required'              =>  true,
            'label'                 =>  false,
            'constraints'           =>  array(new NotBlank(array('message' => 'Vous n\'avez pas indiqué votre Email')), new Email(
                array(
                    'message' => 'Veuillez saisir une adresse mail valide',
                    'strict'  => true,
                    'checkMX' => true
                )
            )),
            'attr'                  =>  [
                'class'             => 'form-control',
            ]
        ])
        ->add('password', RepeatedType::class, array(
            'type'                  => PasswordType::class,
            'first_options'         => array(
                'label'             => false,
                'constraints'       => array(new PasswordConstraint()),
                'attr'              => [
                    'class'         => 'form-control',
                    'placeholder'   => 'Entrez votre mot de passe'
                    ]
            ),
            'second_options' => array(
                'label'             => false,
                'attr'              => [
                    'class'         => 'form-control',
                    'placeholder'   => 'Confirmer votre mot de passe'
                    ]
            ),
            'invalid_message'   => 'Les deux mots de passe doivent être identiques',
            'attr' => [
                'class'             => 'form-control'
                ]
        ))
        ->add('submit', SubmitType::class, ['label' => 'Enregistrer'])

        ;
    }

}