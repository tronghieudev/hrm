<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/9/2016
 * Time: 2:46 PM
 */

App::uses('ADController', 'Controller');
App::uses('Position', 'Model');
/**
 * class position
 * @property ADController
 * @property Position
 * manage positon staff in company
*/
class PositionsController extends  ADController {
    public $components = array('Paginator');

    public $paginate = array(
        'limit' => 20,
        'conditions' => array(
            'Position.status' => 1
        ),
    );

    public function beforeFilter() {
        parent::beforeFilter(); // TODO: Change the autogenerated stub
        $this->loadModel('Position');
        $this->layout = 'admin';
    }

    /**
     * function index get list position
    */
    public function admin_index() {

//        $input = $this->request->query;
        $this->Paginator->settings = $this->paginate;
        $data = $this->Paginator->paginate('Position');
        $this->set('data', $data);
    }


    /**
     * function post create - method ajax
     * @return json
     */
    public function admin_create(){

        $this->autoRender = false;
        if($this->request->is('ajax')) {

            // validate
            $this->Position->set($this->request->data);
            if(!$this->Position->validates()) {
                return $this->_falseJson(Constants::BAD_REQUEST, null, $this->Position->validationErrors);
            }

            $this->Position->create();
            $model = $this->Position->save($this->request->data);
            if($model) {
                return $this->_trueJson(['message' => 'Create new position success!']);
            }
            return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Create new position false!']);
        }
    }

    /**
     * function get by id - method ajax
     * @return json
    */
    public function admin_getById() {

        $this->autoRender = false;
        if($this->request->is('ajax')) {
            $id = $this->request->query['id'];
            $data = $this->Position->findById($id);
            if($data) {
                return $this->_trueJson($data['Position']);
            }
            return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Data is null']);
        }
    }

    /**
     * function edit position by method ajax
    */
    public function admin_edit(){

        $this->autoRender = false;
        if($this->request->is('ajax')) {

            // validate
            $this->Position->set($this->request->data);
            if(!$this->Position->validates()) {
                return $this->_falseJson(Constants::BAD_REQUEST, null, $this->Position->validationErrors);
            }

            $this->Position->id = $this->request->data['id'];
            $model = $this->Position->save($this->request->data);
            if($model) {
                return $this->_trueJson(['message' => 'Edit success!']);
            }
            return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Edit false!']);
        }
    }

    /**
     * function ajax remove postion
     * @
     * @return json
    */
    public function admin_remove() {

        $this->autoRender = false;
        if($this->request->is('ajax')) {
            $this->Position->validate = [];
            $this->Position->id = $this->request->query['id'];
            $model = $this->Position->save(['status' => 0]);
            if($model) {
                return $this->_trueJson(['message' => 'Remove item success!']);
            }
            return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Remove item false!']);
        }
    }
}