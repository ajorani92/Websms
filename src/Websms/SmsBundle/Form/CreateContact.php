<?php

namespace Websms\SmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateContact extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
            ->add('number', 'text')
            ->add('group', 'entity', array(
                'class' => 'SmsBundle:Group',
                'property' => 'name',
                'attr' => array('style' => 'width:50px', 'aria-controls' => 'DataTables_Table_1')
            ))
            ->add('save', 'submit', array('attr' => array('formnovalidate' => 'formnovalidate'), 'label' => 'Save'))
        ;
    }

    public function getName()
    {
        return 'CreateGroup';
    }
}
