<?php

namespace Websms\SmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SendSms extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('destination', 'text')
                ->add('sender', 'text')
                ->add('message', 'textarea')
                //->add('name', 'textarea', array('mapped' => false))
                //->add('date', 'date', array('widget' => 'single_text'))
                ->add('save', 'submit', array('attr' => array('formnovalidate' => 'formnovalidate'), 'label' => 'Send'))
        ;
    }

    public function getName()
    {
        return 'SendSms';
    }
}
