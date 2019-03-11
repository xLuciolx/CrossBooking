<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

use App\Entity\Pointer;

class PointerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_book', TextType::class, [
                'required'          =>  true,
                'label'             =>  false,
                'mapped'            =>  false,
                'constraints'       =>  array(
                    new Regex(
                    array(
                        'pattern'   => '([\d]{8})',
                        'message'   => 'Numéro incorrect - Doit contenir 8 chiffres')),
                    new NotBlank(array(
                        'message'   => 'Vous devez saisir un numéro')),
                    ),
                'attr'              =>  [
                    'class'         => 'form-control',
                    'autocomplete'  => 'off'
                ]
            ])
            ->add('address', TextType::class, [
                'required'      =>  true,
                'mapped'        => false,
                'constraints'   =>  array(new NotBlank(array('message'=>'Vous n\'avez pas indiqué votre ville'))),
                'label'         =>  false,
                'attr'          => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('city', HiddenType::class, [
                'required'      =>  false
            ])
            ->add('latitude', HiddenType::class, [
                'required'      =>  false
            ])
            ->add('longitude', HiddenType::class, [
                'required'      =>  false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pointer::class,
        ]);
    }
}
