<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
        'Session',
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'auth',
                'action' => 'login',
                'admin' => false,
            ),
            'authenticate' => array(
                'Form' => array(
                    'fields' => array(
                        'username' => 'email', //Default is 'username' in the userModel
                        'password' => 'password'  //Default is 'password' in the userModel
                    )
                )
            )
        ),
        'Transaction'
    );

    public function beforeFilter()
    {
        $this->Auth->allow('login', 'register');
    }

    /**
     * Build json response for api request
     *
     * @param bool $status
     * @param array $result
     * @param array $extra
     *
     * @return bool
     */
    public function _buildJson($status, $result = null, $extra = array()) {
        $response = [
            'status' => Constants::OK,
            'message' => 'OK',
            'success' => $status
        ];

        if (is_array($extra)) {
            $response = array_merge($response, $extra);
        }

        if (!is_null($result)) {
            $response['data'] = $result;
        }

        $this->layout = $this->autoRender = false;
        $this->response->type('application/json');
        $this->response->body(json_encode($response));

        return true;
    }

    /**
     * Failure json response
     *
     * @param int $errorCode
     * @param string $errorMessage
     * @param array $extra
     *
     * @return bool
     */
    public function _falseJson($errorCode = null, $errorMessage = '', $extra = []) {

        $response = [
            'status' => $errorCode,
            'message' => $errorMessage
        ];

        if (!empty($extra)) {
            $response['errors'] = $extra;
        }

        return $this->_buildJson(false, null, $response);
    }

    /**
     * True json response
     *
     * @param array $data
     * @param array $extra
     *
     * @return bool
     */
    public function _trueJson($data = [], $extra = null) {
        return $this->_buildJson(true, $data, $extra);
    }

    public function countDay($y,$m){ 
        $date = "$y-$m-01";
        $first_day = date('N',strtotime($date));
        $first_sunday = 7 - $first_day + 1;
        $last_day =  date('t',strtotime($date));
        $days = array();
        for($i=$first_sunday; $i<=$last_day; $i=$i+7 ){
            $days[] = $i;
        }
        for($i= 7 - $first_day; $i<=$last_day; $i=$i+7 ){
            if($i >0) {
                $days[] = $i;
            }
        }
        // return count($days);
        $total_day = date('t', strtotime(date("$y-$m-t"))) - count($days);
        return  $total_day;
    }

}
