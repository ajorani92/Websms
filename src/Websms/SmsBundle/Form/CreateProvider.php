<?php

namespace Websms\SmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateProvider extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
                ->add('host', 'text')
                ->add('message', 'text')
                ->add('sender', 'text')
                ->add('destination', 'text')
                ->add('enabled', 'checkbox')
                ->add('save', 'submit', array('attr' => array('formnovalidate' => 'formnovalidate'), 'label' => 'Save'));
    }

    public function getName()
    {
        return 'CreateProvider';
    }
}