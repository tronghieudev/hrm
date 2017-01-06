<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/9/2016
 * Time: 2:44 PM
 */

App::uses('AppModel', 'Model');

class Currency extends AppModel {

    public $name = 'currencies';

    public $validate = [
        'name' => [
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'A password is required',
                'required' => true
            )
        ],
        'symbol' => [
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'A password is required',
                'required' => true
            )
        ]
    ];
}