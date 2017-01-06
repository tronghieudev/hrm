<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/3/2017
 * Time: 13:20
 */

App::uses('AppModel', 'Model');

class Calendar extends AppModel {

    public $name = 'calendars';

    public $hasMany = array(
        'CalendarDetail' => array(
            'className' => 'CalendarDetail',
            'foreignKey' => 'calendars_id'
        )
    );

    public $belongsTo = [
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'users_id'
        )
    ];
}