<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\IsTrue;

use App\Util\Constraints\PasswordConstraint;
use App\Entity\Member;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('pseudo', TextType::class, [
            'required'      =>  true,
            'label'         =>  false,
            'constraints'   =>  array(new NotBlank(array('message' => 'Vous n\'avez pas indiqué votre Pseudo' ))),
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
        ->add('password', RepeatedType::class, array(
            'type' => PasswordType::class,
            'first_options'  => array(
                'label'      => false,
                'constraints'=> array(new PasswordConstraint()),
                'attr'       => [
                    'placeholder' => 'Entrez votre mot de passe',
                    'class'       => 'form-control'
                ]
            ),
            'second_options' => array(
                'label'      => false,
                'attr'       => [
                    'placeholder' => 'Confirmez votre mot de passe',
                    'class'       => 'form-control'
                ]
            ),
            'invalid_message' => 'Les deux mots de passe doivent être identiques',
            'attr' => [
                'class'           => 'form-control'
                ]
        ))
        ->add('avatar', FileType::class, [
            'required'            =>  false,
            'label'               =>  false,
            'attr'                =>  [
                'class'           => 'form-control dropify',
                'data-allowed-file-extensions' => 'jpg jpeg png'
            ]
        ])
        ->add('termsAccepted', CheckboxType::class, array(
            'label'               =>  'J\'ai lu et j\'accepte les termes et conditions',
            'mapped'              =>  false,
            'constraints'         =>  new IsTrue(array('message'=>'Champs obligatoire')),
        ))
        ->add('submit', SubmitType::class, ['label' => 'S\'inscrire'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
