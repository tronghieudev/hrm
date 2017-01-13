<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/9/2016
 * Time: 2:46 PM
 */

App::uses('ADController', 'Controller');
App::uses('User', 'Model');
App::uses('UsersDaysOff', 'Model');

/**
 * class position
 * @property ADController
 * @property Position
 * manage positon staff in company
*/
class DayoffsController extends  ADController {

    public $components = array('Paginator');

    public $paginate = array(
        'limit' => 20,
        'conditions' => array(
            'UsersDaysOff.status' => Constants::STATUS_LIVE
        ),
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->loadModel('UsersDaysOff');
        $this->layout = 'admin';
    }

    public function admin_index() {

        $this->paginate['conditions'] = [
            'UsersDaysOff.status' => 0
        ];
        $this->paginate['order'] = ['UsersDaysOff.time_in' => 'DESC'];
        $this->Paginator->settings = $this->paginate;
        $data = $this->Paginator->paginate('UsersDaysOff');
        $this->set('data', $data);
    }

    public function admin_check() {
    	$this->autoRender = false;

        if(!$this->request->data['id']) {
            return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Data is null']);
        }
        $this->UsersDaysOff->validate = [];
        $this->UsersDaysOff->id = $this->request->data['id'];
        $result = $this->UsersDaysOff->save(['status' => 1]);
        if ($result) {
            return $this->_trueJson(['message' => 'success']);
        }
    }
}
