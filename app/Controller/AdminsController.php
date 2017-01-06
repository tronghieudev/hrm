<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/7/2016
 * Time: 3:39 PM
 */
App::uses('ADController', 'Controller');

class AdminsController extends ADController {

    public function beforeFilter() {
        $this->layout = 'admin';
        parent::beforeFilter();
        $this->loadModel('User');
    }

    public function admin_index() {

        $data = $this->User->find('all');
//        debug($data);die;
//        $this->autoRender = false;
    }
}