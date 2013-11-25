<?php

namespace Websms\SmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateGroup extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
            ->add('description', 'textarea')
            ->add('save', 'submit', array('attr' => array('formnovalidate' => 'formnovalidate'), 'label' => 'Create'))
        ;
    }

    public function getName()
    {
        return 'CreateGroup';
    }
}
