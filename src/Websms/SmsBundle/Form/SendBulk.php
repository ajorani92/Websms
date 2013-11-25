<?php

namespace Websms\SmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SendBulk extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*$builder->add('destination', 'file', array(
                'constraints' => array(
                    new NotBlank()
                )
            ))
            ->add('sender', 'text', array(
                'constraints' => array(
                    new NotBlank(),
                    new Length(array('min' => 3, 'max' => 12)),
                )
            ))
            ->add('message', 'textarea', array(
                'constraints' => array(
                    new NotBlank(),
                    new Length(array('max' => 160))
                )
            ))
            ->add('save', 'submit', array('attr' => array('formnovalidate' => 'formnovalidate'), 'label' => 'Send'))
        ;*/

        $builder->add('bulkFile', 'file')
            ->add('destination', 'hidden', array('data' => 1234567889))
            ->add('sender', 'text')
            ->add('message', 'textarea')
            ->add('save', 'submit', array('attr' => array('formnovalidate' => 'formnovalidate'), 'label' => 'Send'))
        ;
    }

    public function getName()
    {
        return 'SendBulk';
    }
}
