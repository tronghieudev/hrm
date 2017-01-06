<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/7/2016
 * Time: 2:30 PM
 */
App::uses('USController', 'Controller');

class UsersController extends USController {

    public function index() {
    	return $this->redirect(['controller' => 'calendars', 'action' => 'index']);
    }

    public function logout() {
        if($this->Auth->logout()) {
            return $this->redirect(['action' => 'login']);
        }
    }
}