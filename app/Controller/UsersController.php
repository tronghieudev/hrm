<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/7/2016
 * Time: 2:30 PM
 */
App::uses('USController', 'Controller');
App::uses('User', 'Model');
App::uses('UsersProfile', 'Model');
App::uses('UsersSalary', 'Model');
App::uses('UsersOvertime', 'Model');
App::uses('Position', 'Model');
App::uses('Department', 'Model');
App::uses('Curency', 'Model');
App::uses('UsersDaysOff', 'Model');
App::uses('UsersDaysLeave', 'Model');
class UsersController extends USController {

	public function beforeFilter() {
        parent::beforeFilter(); //
        $this->loadModel('User');
        $this->loadModel('UsersProfile');
        $this->loadModel('Position');
        $this->loadModel('Department');
        $this->loadModel('Currency');
        $this->loadModel('UsersOvertime');
        $this->loadModel('UsersDaysOff');
        $this->loadModel('UsersDaysLeave');
        $this->loadModel('UsersSalary', 'Model');
        
    }

    public function index() {

    	$this->layout = false;
    	$id = $this->Auth->user('id');

    	// debug($id);
    	$data = $this->User->find('first', [
    		'contain' => [
    			'UsersProfile',
    			'UsersDaysLeave' => [
	                'conditions' => [
	                    'UsersDaysLeave.day_start >=' => date("Y-m-01"),
	                    'AND' => [
	                        'UsersDaysLeave.day_start <=' => date("Y-m-t"),
	                    ]
	                    
	                ],
	                'fields' => array('sum(UsersDaysLeave.days) AS total'),
	                
	            ],
	            'UsersDaysOff' => [
	                'conditions' => [
	                    'UsersDaysOff.status' => 1,
	                    'UsersDaysOff.day_start >=' => date("Y-m-01"),
	                    'AND' => [
	                        'UsersDaysOff.day_start <=' => date("Y-m-t"),
	                    ],
	                               
	                ],
	                'fields' => array('sum(UsersDaysOff.days) AS total'),
	                
	            ],
	            'UsersOvertime' => [
	                'conditions' => [
	                    'UsersOvertime.status' => 1,
	                    'UsersOvertime.time_in >=' => date("Y-m-01"),
	                    'AND' => [
	                        'UsersOvertime.time_in <=' => date("Y-m-t 23:59:59"),
	                    ],
	                    
	                ],
	            ]
    		],
    		'conditions' => [
    			'User.id' => $id
    		]
    	]);
    	$overtime = [
            'day_normal' => 0,
            'day_off' => 0,
            'holiday' => 0
        ];

        foreach ($data['UsersOvertime'] as $value) {
            switch ($value['type']) {
                case Constants::TYPE_DAY_NORMAL:
                    $overtime['day_normal'] += (strtotime($value['time_out']) - strtotime($value['time_in'])) / 3600;
                    break;
                case Constants::TYPE_DAY_OFF:
                    $overtime['day_off'] += (strtotime($value['time_out']) - strtotime($value['time_in'])) / 3600;
                    break;

                default:
                    $overtime['holiday'] += (strtotime($value['time_out']) - strtotime($value['time_in'])) / 3600;
                    break;
            }
        }

        $this->set('data', $data);
        $this->set('overtime', $overtime);
	}    

    public function dayLeave() {

    	if(empty($this->request->data['users_id']) || $this->request->data['users_id'] != $this->Auth->user('id')) {
            return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Data null']);
        }
        
        $this->UsersDaysLeave->set($this->request->data);

        if (!$this->UsersDaysLeave->validates()) {
            return $this->_falseJson(Constants::BAD_REQUEST, null, $this->UsersDaysLeave->validationErrors);
        }

        $id = $this->request->data['users_id'];
        $user = $this->User->findById($id);
        if ($user) {
            $days_leave = $user['User']['days_leave'];

            // check day leave
            if ($days_leave <= 0) {
                return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Bạn đã hết ngày nghĩ phép']);
            }

            if ($days_leave - $this->request->data['days'] < 12 - date('m')) {
                return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Số ngày nghỉ phép của bạn vượt qua mức cho phép']);
            }

            $this->UsersDaysLeave->create();
            $result = $this->UsersDaysLeave->save($this->request->data);
            if ($result) {

                $days = $days_leave - $this->request->data['days'];
                $this->User->id = $id;
                $this->User->validate = [];
                $this->User->save(['id' => $id, 'days_leave' => $days]);
                return $this->_trueJson(['message' => 'Set day off success']);
            } else {
                return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Set day off false']);
            }
        } else {
            return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'User null']);
        }
    }

    public function dayOff() {

    	if(empty($this->request->data['users_id']) || $this->request->data['users_id'] != $this->Auth->user('id')) {
            return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Data null']);
        }

        $this->UsersDaysOff->set($this->request->data);

        if (!$this->UsersDaysOff->validates()) {
            return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Validate false']);
        }

        $this->UsersDaysOff->create();
        $result = $this->UsersDaysOff->save($this->request->data);
        if ($result) {
            return $this->_trueJson(['message' => 'Set day off success']);
        } else {
            return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Set day off false']);
        }
    }

    public function overtime() {
    	
    	$this->autoRender = false;
        if($this->request->is('ajax')) {

            $input = [];
            // convert input
            $input['type'] = $this->request->data['type'];
            $input['users_id'] = $this->request->data['id'];
            $input['time_in'] = date('Y-m-d', strtotime($this->request->data['time_in_date'])).' '.date('H:i:s', strtotime($this->request->data['time_in_time']));
            $input['time_out'] = date('Y-m-d', strtotime($this->request->data['time_out_date'])).' '.date('H:i:s', strtotime($this->request->data['time_out_time']));

            $this->UsersProfile->validate = [
                'time_in' => [
                    'required' => array(
                        'rule' => array('notBlank'),
                        'message' => 'A time in is required',
                        'required' => true
                    ),
                ],
                'time_out' => [
                    'required' => array(
                        'rule' => array('notBlank'),
                        'message' => 'A time out is required',
                        'required' => true
                    ),
                    'checkOverTime' => array(
                        'rule' => array('checkOverTime', 'time_in'),
                        'message' => 'A time out not < time in',
                        'required' => true
                    ),

                ]
            ];
            $this->UsersProfile->set($input);
            if(!$this->UsersProfile->validates()) {
                return $this->_falseJson(Constants::BAD_REQUEST, null, ['valid' => $this->UsersProfile->validationErrors]);
            }

            $this->Transaction->begin();
            $this->UsersOvertime->create();
            $result = $this->UsersOvertime->save($input);

            if($result) {

                $this->Transaction->commit();
                return $this->_trueJson($result['UsersOvertime']);
            }

            return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Set overtime false']);
            $this->Transaction->rollback();
        }
    }

    public function logout() {
        if($this->Auth->logout()) {
            return $this->redirect(['action' => 'login']);
        }
    }
}