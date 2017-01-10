<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/3/2017
 * Time: 13:20
 */

App::uses('AppModel', 'Model');

class UsersDaysLeave extends AppModel {

    public $name = 'users_days_leaves';

    public $belongsTo = [
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'users_id'
        )
    ];

    public $validate = [
        'day_start' => [
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'A day start is required',
                'required' => true
            ),
            'date' => [
                'rule' => 'date',
                'message' => 'Enter a valid date',
                'allowEmpty' => true
            ]
        ],
        'days' => [
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'A day start is required',
                'required' => true
            ),
            'number' => [
                'rule' => 'numeric',
                'message' => 'Please supply the number.'
            ]
        ]
    ];
}