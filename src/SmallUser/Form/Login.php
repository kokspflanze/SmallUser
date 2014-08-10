<?php

namespace SmallUser\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use ZfcBase\Form\ProvidesEventsForm;

class Login extends ProvidesEventsForm {

    public function __construct(){
        parent::__construct();

        $this->add(array(
            'name' => 'username',
            'options' => array(
                'label' => 'Username',
            ),
            'attributes' => array(
                'placeholder' => 'Username',
                'class' => 'form-control',
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'options' => array(
                'label' => 'Password',
            ),
            'attributes' => array(
                'placeholder' => 'Password',
                'class' => 'form-control',
                'type' => 'password'
            ),
        ));

        $submitElement = new Element\Button('submit');
        $submitElement
            ->setLabel('Sign In')
            ->setAttributes(array(
                'class' => 'btn btn-default',
                'type'  => 'submit',
            ));

        $this->add($submitElement, array(
            'priority' => -100,
        ));
    }
}