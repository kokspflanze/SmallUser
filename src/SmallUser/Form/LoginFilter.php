<?php

namespace SmallUser\Form;


use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter
{
    /**
     * LoginFilter constructor.
     */
    public function __construct()
    {
        $this->add([
            'name' => 'username',
            'required' => true,
            'filters' => [['name' => 'StringTrim']],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 3,
                        'max' => 16,
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'password',
            'required' => true,
            'filters' => [['name' => 'StringTrim']],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 6,
                        'max' => 32,
                    ],
                ],
            ],
        ]);
    }
}