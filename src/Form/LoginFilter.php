<?php

namespace SmallUser\Form;

use Laminas\Filter;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator;

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
            'filters' => [
                ['name' => Filter\StringTrim::class]
            ],
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
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
            'filters' => [
                ['name' => Filter\StringTrim::class]
            ],
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'min' => 6,
                        'max' => 32,
                    ],
                ],
            ],
        ]);
    }
}