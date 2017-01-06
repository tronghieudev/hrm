<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/9/2016
 * Time: 2:46 PM
 */

App::uses('ADController', 'Controller');
App::uses('User', 'Model');
App::uses('UsersProfile', 'Model');
App::uses('UsersOvertime', 'Model');
App::uses('Position', 'Model');
App::uses('Department', 'Model');
App::uses('Curency', 'Model');

/**
 * class position
 * @property ADController
 * @property Position
 * manage positon staff in company
*/
class StaffsController extends  ADController {
    public $components = array('Paginator');

    public $paginate = array(
        'limit' => 20,
        'conditions' => array(
            'User.status' => 1
        ),
    );

    public function beforeFilter() {
        parent::beforeFilter(); //
        $this->loadModel('User');
        $this->loadModel('UsersProfile');
        $this->loadModel('Position');
        $this->loadModel('Department');
        $this->loadModel('Currency');
        $this->loadModel('UsersOvertime');
        $this->layout = 'admin';
    }

    /**
     * function index - get list staff
    */
    public function admin_index() {
        if($this->request->is('post')) {
            debug(date('Y-m-d', strtotime($this->request->data['time_in']['date'])).' '.date('H:i:s', strtotime($this->request->data['time_in']['time'])));die;
        }else{
            // echo 1;die;
        }
        $input = $this->request->query;
        $conditions = [];
        if(!empty($input['fullname'])) {

            $conditions['UsersProfile.fullname LIKE'] = '%'.$input['fullname'].'%';
        }

        if(!empty($input['email'])) {

            $conditions['User.email LIKE'] = '%'.$input['email'].'%';
        }

        if(!empty($input['phone_number'])) {

            $conditions['UsersProfile.phone_number LIKE'] = '%'.$input['phone_number'].'%';
        }
        
        if(!empty($conditions)) {
            $this->paginate['conditions'] = array_merge($this->paginate['conditions'], $conditions);
        }
        $this->Paginator->settings = $this->paginate;
        // debug($this->Paginator->settings);die;
        $data = $this->Paginator->paginate('UsersProfile');
        $currencies = $this->Currency->find('list', ['conditions' => ['Currency.status' => 1]]);
        $this->set('currencies', $currencies);
        $this->set('data', $data);
    }


    /**
     * function create staff
     */
    public function admin_create(){

        //method post
        if($this->request->is('post')) {
            $validator = $this->User->validator();
            unset($validator['password_update']);
            unset($validator['re_password_update']);

            //validate User
            $this->User->set($this->request->data);
            $validUser = $this->User->validates();
            //validate UsersProfile
            $this->UsersProfile->set($this->request->data);
            $validUserProfile = $this->UsersProfile->validates();

            // check validate
            if(!$validUser || !$validUserProfile) {

                $resultValid = array_merge($this->User->validationErrors, $this->UsersProfile->validationErrors);
                $this->set('errors', $resultValid);
            } else {

                $this->Transaction->begin();
                $email = $this->request->data['email'];
                $username = explode('@', $email)[0];
                $user = $this->User->save(['password' => '12345678', 'email' => $email, 'username' => $username, 'roles_id' => 2]);
                if($user) {
                    $data = $this->request->data;
                    $data['users_id'] = $user['User']['id'];
                    //  birthday
                    $data['birthday'] = $data['birthday']['y'].'-'.$data['birthday']['m'].'-'.$data['birthday']['d'];
                    $userProfile = $this->UsersProfile->save($data);
                    if($userProfile) {
                        $this->Transaction->commit();
                        $this->Session->setFlash('Create staff success !');
                        $this->redirect(['action' => 'index']);
                    }else{
                        $this->Transaction->rollback();
                    }
                }
            }
        }

        // method get
        $listPostions = $this->Position->find('list', ['conditions' => ['Position.status' => 1]]);
        $listDepartments = $this->Department->find('list', ['conditions' => ['Department.status' => 1]]);
        $this->set(['listPostions' => $listPostions, 'listDepartments' => $listDepartments]);
    }

    /**
     * function view detail
     * @param int $id
     */
    public function admin_view($id = null) {

        $this->UsersProfile->recursive = 2;
        $data = $this->UsersProfile->findById($id);
        $this->set('data', $data);
    }

    /**
     * function get by id - method ajax
     * @return json
     */
    public function admin_getById() {

        $this->autoRender = false;
        if($this->request->is('ajax')) {
            $id = $this->request->data['id'];
            $data = $this->UsersProfile->findById($id);
            if($data) {
                return $this->_trueJson($data);
            }
            return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Data is null']);
        }
    }

    /**
     * function update salary
     * @param salary
     * @param currencies_id
     * @param id
     * @return json
    */
    public function admin_updateSalary() {
        $this->autoRender = false;
        $validate = [
            'salary' => [
                'required' => array(
                    'rule' => array('notBlank'),
                    'message' => 'A gender is required',
                    'required' => true
                ),
                'numeric' => array(
                    'rule' => array('numeric'),
                    'message' => 'A gender is required',
                    'required' => true
                )
            ],
            'currencies_id' => [
                'required' => array(
                    'rule' => array('notBlank'),
                    'message' => 'A currency is required',
                    'required' => true
                )
            ]
        ];
        if($this->request->is('ajax')) {
            $this->UsersProfile->validate = $validate;
            $this->UsersProfile->set($this->request->data);

            // check validate
            if (!$this->UsersProfile->validates()) {
                return $this->_falseJson(Constants::BAD_REQUEST, null, $this->UsersProfile->validationErrors);
            }

            // update salary
            $result = $this->UsersProfile->save($this->request->data);
            if ($result) {

                return $this->_trueJson(['message' => 'Update salary success!']);
            } else {
                $this->Transaction->rollback();
                return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Update salary false!']);
            }
        }
    }

    /**
     * function reset password , to be default 12345678
     * @param id
     * @method ajax
     * @return json
    */
    function admin_resetPassword() {

        if($this->request->is('ajax')) {

            $user_profile = $this->UsersProfile->findById($this->request->data['id']);
            // change password default = 12345678;
            $user_id = $user_profile['UsersProfile']['users_id'];
            $this->User->validate = [];
            $result = $this->User->save(['id' => $user_id, 'password' => '12345678']);
            if($result) {
                return $this->_trueJson(['message' => 'Reset password success = 12345678!']);
            } else {
                return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Change password false!']);
            }
        }
    }

    /**
     * function upload avata
     * @property uploadFile
     */
    function admin_uploadAvata() {
        $this->autoRender = false;
        $this->UsersProfile->validate = [
            'avata' => array(
                'size' => [
                    'rule' => array('fileSize', '<=', '1MB'),
                    'message' => 'Image must be less than 1MB'
                ],
                'mimeType' => [
                    'rule' => array(
                        'extension',
                        array('gif', 'jpeg', 'png', 'jpg')
                    ),
                    'message' => 'Please supply a valid image.'
                ]
            )
        ];

        //validate
        $this->UsersProfile->set($this->request->data);
        if(!$this->UsersProfile->validates()) {
            $this->Session->setFlash('Validate false !');
            $this->redirect(['action' => 'index']);
        }

        $file_name = $this->request->data['avata']['name'];
        $tmp_name = $this->request->data['avata']['tmp_name'];

        $file_old = $this->UsersProfile->findById($this->request->data['id']);
        $result = $this->uploadFile($file_name, $tmp_name, Constants::AVATA_URL, $file_old['UsersProfile']['avata']);

        if ($result) {
            $this->UsersProfile->save(['id' => $this->request->data['id'], 'avata' => $result]);
            $this->Session->setFlash('Update avata success !');
            return $this->redirect(['action' => 'index']);
        }

        $this->Session->setFlash('Update avata false !');
        return $this->redirect(['action' => 'index']);
    }

    function admin_uploadCV() {
        $this->autoRender = false;
        $this->UsersProfile->validate = [
            'cv' => array(
                'size' => [
                    'rule' => array('fileSize', '<=', '2MB'),
                    'message' => 'Image must be less than 2MB'
                ],
                'mimeType' => [
                    'rule' => array(
                        'extension',
                        array('doc', 'docx', 'pdf')
                    ),
                    'message' => 'Please supply a valid image.'
                ]
            )
        ];

        //validate
        $this->UsersProfile->set($this->request->data);
        if(!$this->UsersProfile->validates()) {
            $this->Session->setFlash('Validate false !');
            $this->redirect(['action' => 'index']);
        }

        $file_name = $this->request->data['cv']['name'];
        $tmp_name = $this->request->data['cv']['tmp_name'];

        // get file old => delelte.
        $file_old = $this->UsersProfile->findById($this->request->data['id']);
        $result = $this->uploadFile($file_name, $tmp_name, Constants::CV_URL, $file_old['UsersProfile']['cv']);
        if ($result) {
            $this->UsersProfile->save(['id' => $this->request->data['id'], 'cv' => $result]);
            $this->Session->setFlash('Update CV success !');
            return $this->redirect(['action' => 'index']);
        }

        $this->Session->setFlash('Update avata false !');
        return $this->redirect(['action' => 'index']);
    }

    /**
     * function uploadfile
     * @param $name
     * @param $tmp_name
     * @return boolean
     */
    function uploadFile($name, $tmp_name, $url = null, $file_old = null) {


        if(empty($name) || empty($tmp_name) || empty($url)) {
            return false;
        }
        $convertName = time().'-'.$name;
        $url_upload = WWW_ROOT . $url . $convertName;

        // check isset file old => delete

        if(!empty($file_old)) {
            if(file_exists(WWW_ROOT . $url.$file_old)) {
                unlink(WWW_ROOT . $url.$file_old);
            }
        }

        // upload
        $result = move_uploaded_file($tmp_name, $url_upload);
        if ($result) {

            return $convertName;
        }
        return false;
    }

    function admin_setOvertime() {

        $this->autoRender = false;
//        return 1;
        if($this->request->is('ajax')) {

            $input = [];

            // convert input
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

    public function admin_viewOvertime() {

        if(empty($this->request->data['id'])) {
            return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Data null']);
        }

        $id = $this->request->data['id'];
        $conditions = [];
        if (isset($this->request->data['month']) && isset($this->request->data['year'])) {
            $conditions = array(
                'UsersOvertime.users_id' => $id,
                'UsersOvertime.time_in >=' => date('Y-m-d', strtotime($this->request->data['year'].'-'.$this->request->data['month'])),
                'UsersOvertime.time_out <=' => date('Y-m-t 23:59:59', strtotime($this->request->data['year'].'-'.$this->request->data['month']))
            );
        } else {
            $conditions = array(
                'UsersOvertime.users_id' => $id,
                'UsersOvertime.time_in >=' => date('Y-m-d', time()),
                'UsersOvertime.time_out <=' => date('Y-m-t 23:59:59', time())
            );
        }
        $data = $this->UsersOvertime->find('all',array(
            'conditions' => $conditions
        ));
        return $this->_trueJson($data);
    }
}