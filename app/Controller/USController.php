<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/7/2016
 * Time: 2:20 PM
 */
App::uses('AppController', 'Controller');
/**
 * Class AD = Admin check role for admin
*/
class USController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $role = $this->Auth->user()['roles_id'];
        if($role != Constants::USER) {
            $this->redirect(['controller' => 'auth','action' => 'admin_notPermission']);
        }
    }
}