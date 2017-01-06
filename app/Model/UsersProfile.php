<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/13/2016
 * Time: 8:53 AM
 */
App::uses('AppModel', 'Model');

/**
 * class UsersProfile
*/
class UsersProfile extends AppModel {


    // var array validate
    public $validate = [
        'fullname' => [
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'A fullname is required',
                'required' => true
            )
        ],
        'address' => [
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'A address is required',
                'required' => true
            )
        ],
        'phone_number' => [
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'A phone number is required',
                'required' => true
            ),
            'check_phone' => array(
                'rule' => '/^[0-9\s\+]{9,15}$/i',
                'message' => 'Phone number is not format',
                'required' => true
            )
        ],
        'gender' => [
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'A gender is required',
                'required' => true
            ),
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => 'A gender is required',
                'required' => true
            )
        ]
    ];

    // relationship
    public $belongsTo = [
        'User' => [
            'className' => 'User',
            'foreignKey' => 'users_id'
        ],
        'Currency' => [
            'className' => 'Currency',
            'foreignKey' => 'currencies_id'
        ]
    ];

    //
    function checkOverTime($time_out, $time_in) {

        if($this->data[$this->alias][$time_in] < $time_out['time_out']) {
            return true;
        }
        return false;
    }
}