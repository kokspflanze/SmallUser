<?php

namespace SmallUser\Form;

use Laminas\Form;
use Laminas\Form\Element;

class Login extends Form\Form
{
    /**
     * Login constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->add([
            'type' => Element\Csrf::class,
            'name' => 'eugzhoe45gh3o49ugfgj2wrtu7gz50'
        ]);

        $this->add([
            'name' => 'username',
            'options' => [
                'label' => 'Username',
            ],
            'attributes' => [
                'placeholder' => 'Username',
                'class' => 'form-control',
                'type' => 'text'
            ],
        ]);

        $this->add([
            'name' => 'password',
            'options' => [
                'label' => 'Password',
            ],
            'attributes' => [
                'placeholder' => 'Password',
                'class' => 'form-control',
                'type' => 'password'
            ],
        ]);

        $submitElement = new Element\Button('submit');
        $submitElement
            ->setLabel('Sign In')
            ->setAttributes([
                'class' => 'btn btn-secondary',
                'type' => 'submit',
            ]);

        $this->add($submitElement, [
            'priority' => -100,
        ]);
    }
}