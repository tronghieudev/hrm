<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/7/2016
 * Time: 2:11 PM
 */
App::uses('AppController', 'Controller');
App::uses('AuthComponent', 'Controller/Component');


/**
 *  Class authentication manage function login , logout.
 */
class AuthController extends AppController {

    /**
     *
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = false;
        $this->loadModel('User');
        $this->loadModel('UsersProfile');
        $this->loadModel('Department');
        
    }

    /**
     * Function login
     */
    public function login() {

        if ($this->Session->check('Auth.User')) {
            $this->checkRole();
        }

        if($this->request->is('post')) {

            if ($this->Auth->login()) {
                $this->checkRole();
            } else {
                $this->Session->setFlash(__('Invalid username or password'));
            }
        }
    }

    public function logout() {
        if($this->Auth->logout()) {
            return $this->redirect(['action' => 'login']);
        }
    }

    /**
     *
     */
    public function admin_notPermission() {

        debug('You not permission');die();
    }

    /**
     *
     */
    public function checkRole() {

        $role = $this->Auth->user()['roles_id'];
//        debug($role);
        switch ($role) {
            case Constants::ADMIN :
                $this->redirect(['controller' => 'admins','action' => 'index', 'admin' => true]);
                break;
            case Constants::USER :
                $this->redirect(['controller' => 'users','action' => 'index']);
                break;
            default:
                break;
        }
    }

    // function change password by method post ajax
    public function changePassword() {
        $this->autoRender = false;
        $data = $this->request->data;
        if(empty($data)) {
            return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Request data is not null']);
        }
        if($this->request->is('ajax')) {

            $valid = $this->User->validate;
            $this->User->validate = [];
            $this->User->validate['password_update'] = $valid['password_update'];
            $this->User->validate['password_update'] = $valid['re_password_update'];
            $this->User->set($data);
            if(!$this->User->validates()) {
                return $this->_falseJson(Constants::BAD_REQUEST, null, $this->User->validationErrors);
            }
            $input = ['id' => $this->Auth->user()['id'], 'password' => $data['password_update']];
            $result = $this->User->save($input);

            if($result) {
                return $this->_trueJson(['message' => 'Change password success!']);
            }
            return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Change password false!']);
        }
    }

    public function register() {

        if($this->request->is('post')) {
            $validator = $this->User->validator();
            unset($validator['positions_id']);
            //validate User
            $this->User->set($this->request->data);
            $validUser = $this->User->validates();

            // check validate
            if(!$validUser) {

                $this->set('errors', $this->User->validationErrors);
            } else {

                $email = $this->request->data['email'];
                $check_mail = explode('@', $email)[1];
                if ($check_mail == 'nal.vn') {

                    $this->Transaction->begin();
                    $user = $this->User->save(['password' => $this->request->data['password_update'], 'email' => $email, 'roles_id' => 2]);
                    $this->UsersProfile->validate = [];
                    $this->UsersProfile->create();
                    $profile = $this->UsersProfile->save(['users_id' => $user['User']['id']]);
                    if ($profile) {

                        $this->Transaction->commit();
                        $this->set('success', 'Register success');
                    } else {

                        $this->Transaction->rollback();
                        $this->set('error_mail', 'Register false!');
                    }
                } else {
                    $this->set('error_mail', 'Không phải mail NAL');
                }
                
            }
        }

        $teams = $this->Department->find('all', [
            'conditions' => [
                'Department.status' => 1
            ]
        ]);
        $this->set('teams', $teams);
    }
}