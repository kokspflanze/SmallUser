<?php

namespace SmallUser\Form;


use ZfcBase\InputFilter\ProvidesEventsInputFilter;

class LoginFilter extends ProvidesEventsInputFilter
{

    public function __construct( )
    {
        $this->add(array(
            'name'       => 'username',
            'required'   => true,
			'filters'    => array(array('name' => 'StringTrim')),
			'validators' => array(
				array(
					'name'    => 'StringLength',
					'options' => array(
						'min' => 3,
						'max' => 16,
					),
				),
			),
        ));

        $this->add(array(
            'name'       => 'password',
            'required'   => true,
			'filters'    => array(array('name' => 'StringTrim')),
			'validators' => array(
				array(
					'name'    => 'StringLength',
					'options' => array(
						'min' => 6,
						'max' => 16,
					),
				),
			),
        ));
    }
}