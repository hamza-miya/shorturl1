<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordVerificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('password', PasswordType::class, array(
            'error_bubbling'=>true,
            'required' => false,
            'trim' => true,
            'label' => false,
            'attr' => array('placeholder' => 'Placeholder.PassW.PassW', 'maxlength' => 50)));

        $builder->add('send', SubmitType::class, array('label' => "Label.PassW.Send"));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'locale' => 'fr',
        ));
    }
}