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
App::uses('UsersSalary', 'Model');
App::uses('UsersOvertime', 'Model');
App::uses('Position', 'Model');
App::uses('Department', 'Model');
App::uses('Curency', 'Model');
App::uses('UsersDaysOff', 'Model');
App::uses('UsersDaysLeave', 'Model');

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
            'User.status' => Constants::STATUS_LIVE
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
        $this->loadModel('UsersDaysOff');
        $this->loadModel('UsersDaysLeave');
        $this->loadModel('UsersSalary', 'Model');
        $this->loadModel('UsersSalarysSocialInsurance', 'Model');
        
        $this->layout = 'admin';
    }

    /**
     * function index - get list staff
    */
    public function admin_index() {

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
        $data = $this->Paginator->paginate('UsersProfile');
        $currencies = $this->Currency->find('list', ['conditions' => ['Currency.status' => Constants::STATUS_LIVE]]);

        $this->set('currencies', $currencies);
        $this->set('data', $data);
    }


    /**
     * function create staff
     */
    public function admin_create(){

        //method post
        if($this->request->is('post')) {

            // tính lương cơ bản
            $salaryBassic =  $this->request->data['salary'];
            if ($this->request->data['money_phone']) {
                $salaryBassic -= $this->request->data['money_phone'];
            }
            if ($this->request->data['money_lunch']) {
                $salaryBassic -= $this->request->data['money_lunch'];
            }
            if ($this->request->data['money_costume']) {
                $salaryBassic -= $this->request->data['money_costume'];
            }
            if ($this->request->data['money_gasoline']) {
                $salaryBassic -= $this->request->data['money_gasoline'];
            }
            if ($this->request->data['money_house']) {
                $salaryBassic -= $this->request->data['money_house'];
            }
            if ($this->request->data['money_complete']) {
                $salaryBassic -= $this->request->data['money_complete'];
            }
            if ($this->request->data['money_efficiency']) {
                $salaryBassic -= $this->request->data['money_efficiency'];
            }

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
                $user = $this->User->save(['password' => '12345678', 'email' => $email, 'username' => $username, 'roles_id' => Constants::USER]);
                if($user) {

                    // Lưu lương nhân viên
                    $this->UsersSalary->create();
                    $salary = $this->UsersSalary->save(['status' => 1, 'salary' => $this->request->data['salary'], 'users_id' => $user['User']['id']]);

                    // Lưu thông tin nhân viên
                    $data = $this->request->data;
                    $data['users_id'] = $user['User']['id'];

                    //  Birthday
                    $data['birthday'] = $data['birthday']['y'].'-'.$data['birthday']['m'].'-'.$data['birthday']['d'];
                    $userProfile = $this->UsersProfile->save($data);

                    // Lưu lương cơ bản
                    $this->UsersSalarysSocialInsurance->create();
                    $social = $this->UsersSalarysSocialInsurance->save([
                        'status' => 1, 
                        'salary' => $salaryBassic, 
                        'users_id' => $user['User']['id']
                    ]);

                    if($userProfile && $salary && $social) {
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
        $listPostions = $this->Position->find('list', ['conditions' => ['Position.status' => Constants::STATUS_LIVE]]);
        $listDepartments = $this->Department->find('list', ['conditions' => ['Department.status' => Constants::STATUS_LIVE]]);
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
            $id = $this->request->data['users_id'];
            $data = $this->User->find('first', [
                'conditions' => [
                    'User.id' => $id
                ],
                'fields' => [
                    'User.*',
                    'Salary.salary',
                    'Salary.id',
                ],
                'joins' => [
                    [
                        'table' => 'users_salarys',
                        'alias' => 'Salary',
                        'type' => 'LEFT',

                        'conditions' => array(
                            'User.id = Salary.users_id',
                            'Salary.created <=' => date('Y-m-d 23:59:59'),
                            'Salary.status ' => Constants::STATUS_LIVE,
                        ),
                    ]
                ],
                'contain' => []
            ]);
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
            ]
        ];
        if($this->request->is('ajax')) {
            $this->UsersSalary->validate = $validate;
            $this->UsersSalary->set($this->request->data);

            // check validate
            if (!$this->UsersSalary->validates()) {
                return $this->_falseJson(Constants::BAD_REQUEST, null, $this->UsersSalary->validationErrors);
            }

            // update salary
            $check = $this->UsersSalary->find('all', [
                'conditions' => [
                    'UsersSalary.users_id' => $this->request->data['users_id']
                ]
            ]);

            if ($check) {
                $this->UsersSalary->updateAll(
                    ['status' => 0], 
                    ['users_id' => $this->request->data['users_id']]
                );
            }
            $this->UsersSalary->create();
            $result = $this->UsersSalary->save($this->request->data);
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
        if($this->request->is('ajax')) {

            $input = [];
            // convert input
            $input['type'] = $this->request->data['type'];
            $input['status'] = $this->request->data['1'];
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
                'UsersOvertime.time_in >=' => date('Y-m-01', time()),
                'UsersOvertime.time_out <=' => date('Y-m-t 23:59:59', time())
            );
        }
        $data = $this->UsersOvertime->find('all',array(
            'conditions' => $conditions
        ));
        return $this->_trueJson($data);
    }

    public function admin_setDaysOff() {

        if(empty($this->request->data['users_id'])) {
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

    public function admin_setDaysLeave() {

        if(empty($this->request->data['users_id'])) {
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

    // set salary bao hiem xa hoi

    public function admin_setBHXX() {

    }

    public function admin_show() {
        
        if (!$this->request->query['id']) {
            return $this->redirect(['action' => 'index']);
        }
        $id = $this->request->query['id'];
        
        $month = date('m');
        $year = date('Y');

        if(isset($this->request->query['month']) && $this->request->query['month'] > 0 && $this->request->query['month'] <= 12) {
            $month = $this->request->query['month'];
        }

        if(isset($this->request->query['year']) && $this->request->query['year'] > 0 && $this->request->query['year'] <= 12) {
            $year = $this->request->query['year'];
        }

        $options = [];
        $options['fields'] = [
            'User.*',
            'Salary.salary',
            'Salary.id',
        ];
        $options['order'] = ['Salary.created' => 'DESC'];
        $options['joins'] = [
            [
                'table' => 'users_salarys',
                'alias' => 'Salary',
                'type' => 'LEFT',

                'conditions' => array(
                    'User.id = Salary.users_id',
                    'Salary.created <=' => date('Y-m-d 23:59:59'),
                    'Salary.status' => Constants::STATUS_LIVE,
                ),
            ]
        ];

        $options['conditions'] = [
            'User.id' => $id,
        ];

        $options['contain'] = [
            'UsersDaysLeave' => [
                'conditions' => [
                    'UsersDaysLeave.day_start >=' => date("$year-$month-01"),
                    'AND' => [
                        'UsersDaysLeave.day_start <=' => date("$year-$month-t"),
                    ]
                    
                ],
                'fields' => array('sum(UsersDaysLeave.days) AS total'),
                
            ],
            'UsersDaysOff' => [
                'conditions' => [
                    'UsersDaysOff.status' => 1,
                    'UsersDaysOff.day_start >=' => date("$year-$month-01"),
                    'AND' => [
                        'UsersDaysOff.day_start <=' => date("$year-$month-t"),
                    ],
                               
                ],
                'fields' => array('sum(UsersDaysOff.days) AS total'),
                
            ],
            'UsersOvertime' => [
                'conditions' => [
                    'UsersOvertime.status' => 1,
                    'UsersOvertime.time_in >=' => date("$year-$month-01"),
                    'AND' => [
                        'UsersOvertime.time_in <=' => date("$year-$month-t 23:59:59"),
                    ],
                    
                ],
            ],
            'UsersSalarysSocialInsurance' => [
                'conditions' => [
                    'UsersSalarysSocialInsurance.created <=' => date("$year-$month-t 23:59:59"),
                    'UsersSalarysSocialInsurance.status' => 1
                ],
            ]
        ];

        $data = $this->User->find('first', $options);
        
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

        if(!$data) {
            return $this->redirect(['action' => 'index']);
        }

        $this->set('data', $data);
        $this->set('overtime', $overtime);
        $this->set('day', $this->countDay($year, $month));
    }
}