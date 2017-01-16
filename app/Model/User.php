<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/7/2016
 * Time: 1:54 PM
 */
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');

/**
 * Class User extends AppModel
 * @property AuthComponent
*/

class User extends AppModel {
    public $actsAs = array('Containable');
    // relationship models
    public $belongsTo = [
        'Role' => [
            'className' => 'Role',
            'foreignKey' => 'roles_id'
        ],
        'Position' => [
            'className' => 'Position',
            'foreignKey' => 'positions_id'
        ],
        'Department' => [
            'className' => 'Department',
            'foreignKey' => 'departments_id'
        ]
    ];

    public $hasMany = array(
        'UsersOvertime' => array(
            'className' => 'UsersOvertime',
            'foreignKey' => 'users_id'
        ),
        'UsersProfile' => array(
            'className' => 'UsersProfile',
            'foreignKey' => 'users_id'
        ),
        'UsersDaysOff' => array(
            'className' => 'UsersDaysOff',
            'foreignKey' => 'users_id'
        ),
        'UsersDaysLeave' => array(
            'className' => 'UsersDaysLeave',
            'foreignKey' => 'users_id'
        ),
        'UsersSalarysSocialInsurance' => array(
            'className' => 'UsersSalarysSocialInsurance',
            'foreignKey' => 'users_id'
        ),
    );

    public function beforeSave($option = []) {

        // hash our password
        if (isset($this->data[$this->alias]['password'])) {

            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        //return parent::beforeSave($options);
    }

    public $validate = [
        'password_update' => [
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'A password is required',
                'required' => true
            ),
            'min_length' => array(
                'rule' => array('minLength', '6'),
                'message' => 'Password must have a mimimum of 6 characters',
                'required' => true
            ),
        ],
        're_password_update' => [
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'A password is required',
                'required' => true
            ),
            'equaltofield' => array(
                'rule' => array('equaltofield','password_update'),
                'message' => 'Both passwords must match.',
                'required' => true
            )
        ],
        'email' => [
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Email is required',
                'required' => true
            ),
            'email' => array(
                'rule' => array('email', true),
                'message' => 'Please supply a valid email address.'
            ),
            'hasUser' => array(
                'rule'    => array('isUniqueEmail'),
                'message' => 'This email is already in use'
            )
        ],
        'positions_id' => [
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Position is required',
                'required' => true
            ),
            'havePos' => array(
                'rule'    => array('isPos'),
                'message' => 'This position null'
            )
        ],
        'departments_id' => [
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Department is required',
                'required' => true
            ),
        ],
        
    ];

    // check qualto password confim
    public function equaltofield($check,$otherfield)
    {
        //get name of field
        $fname = '';
        foreach ($check as $key => $value){
            $fname = $key;
            break;
        }
        return $this->data[$this->alias][$otherfield] === $this->data[$this->alias][$fname];
    }

    // check has email
    function isUniqueEmail($check) {
        $email = $this->find(
            'first',
            array(
                'fields' => array(
                    'User.id',
                    'User.email'
                ),
                'conditions' => array(
                    'User.email' => $check['email']
                )
            )
        );
        // debug($this->data[$this->alias]['email'] === $email['User']['email']);die;
        if(!empty($email)){
            if( $this->data[$this->alias]['email'] == $email['User']['email']) {
                return false;
            }
            return true; 
        }else{
            return true; 
        }
    }

    // check have department
    function isDep($check) {
        $dep = $this->find(
            'first',
            array(
                'fields' => array(
                    'Department.id'
                ),
                'conditions' => array(
                    'Department.id' => $check['departments_id']
                )
            )
        );

        if(!empty($dep)){
            return true; 
        }else{
            return false; 
        }
    }

    // check have position
    function isPos($check) {
        $pos = $this->Position->find(
            'first',
            array(
                'fields' => array(
                    'Position.id'
                ),
                'conditions' => array(
                    'Position.id' => $check['positions_id']
                )
            )
        );

        if(!empty($pos)){
            return true; 
        }else{
            return false; 
        }
    }

    // function check time in $ time out overtimr


}