<?php

App::uses('AppModel', 'Model');

class UsersSalary extends AppModel {
	
	public $name = 'users_salarys';

	public $validate = [
        'salary' => [
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'A day start is required',
                'required' => true
            )
        ]
    ];
}