<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/9/2016
 * Time: 2:46 PM
 */

App::uses('ADController', 'Controller');
App::uses('User', 'Model');
App::uses('UsersDaysLeave', 'Model');

/**
 * class position
 * @property ADController
 * @property Position
 * manage positon staff in company
*/

class DayleavesController extends  ADController {
    public $components = array('Paginator');

    public $paginate = array(
        'limit' => 20,
        'conditions' => array(
            'UsersDaysLeave.status' => Constants::STATUS_LIVE
        ),
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->loadModel('UsersDaysLeave');
        $this->layout = 'admin';
    }
    
    public function admin_index() {

        $this->paginate['conditions'] = [
            'UsersDaysLeave.status' => 0
        ];
        $this->paginate['order'] = ['UsersDaysLeave.time_in' => 'DESC'];
        $this->Paginator->settings = $this->paginate;
        $data = $this->Paginator->paginate('UsersDaysLeave');
        $this->set('data', $data);
    }

    public function admin_check() {
    	
        if(!$this->request->data['id']) {
            return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Data is null']);
        }
        $this->UsersDaysLeave->validate = [];
        $this->UsersDaysLeave->id = $this->request->data['id'];
        $result = $this->UsersDaysLeave->save(['status' => 1]);
        if ($result) {
            return $this->_trueJson(['message' => 'success']);
        }
    }
}