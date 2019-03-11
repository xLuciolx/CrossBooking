<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;


class ContactForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, [
            'required'      =>  true,
            'label'         =>  false,
            'constraints'   =>  array(new NotBlank(array('message'=>'Veuillez saisir votre nom'))),
            'attr'          =>  [
                'class'     => 'form-control',
            ]
        ])
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
        ->add('message', TextareaType::class, [
            'required'      =>  true,
            'label'         =>  false,
            'constraints'   =>  array(new NotBlank(array('message'=>'Veuillez saisir votre message'))),
            'attr'          =>  [
                'class'     => 'form-control',
            ]
        ])

        ;
    }

}