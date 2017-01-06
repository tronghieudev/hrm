<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/3/2017
 * Time: 13:22
 */

App::uses('USController', 'Controller');
App::uses('Calendar', 'Model');
App::uses('CalendarDetail', 'Model');

class CalendarsController extends USController
{

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->loadModel('CalendarDetail');
    }

    /**
     *
     */
    public function index() {
        $this->layout = false;

        $time = time();

        if (isset($this->request->query['day']) && !empty($this->request->query['day'])) {
            $time = strtotime($this->request->query['day']);
            // debug($time);
        }
        $days = [];

        for($i = $time; $i <= $time + 24*60*60*6; $i+=24*60*60){
            $days[date('l', $i)] =  date('Y-m-d', $i);
        }
        
        $this->Calendar->recursive = 2;
        $data = $this->Calendar->find('all', [
            'order' => [
                'Calendar.time_in' => 'ASC'
            ],
            'conditions' => [
                'time_in >=' => date('Y-m-d', time())
            ],

        ]);


        // build data
        $result =[];
        foreach ($data as $val) {
            $day = date('Y-m-d', strtotime($val['Calendar']['time_in']));
                $result[$day][] = $val;
        }
        // debug($data);die;
        $this->set('days', $days);
        $this->set('data', $result);
        $this->set('user_id', $this->Auth->user('id'));
    }

    public function booking() {

        $this->layout = false;
        $this->autoRender = false;
        if($this->request->is('post')) {
            $time_in = $this->request->data['time_in_date'].' '.$this->request->data['time_in_time'];
            $time_out = $this->request->data['time_in_date'].' '.$this->request->data['time_out_time'];
            $time_plus = 15 * 60;
            $array_time = [0, 15, 30, 45];

            if (!in_array(date('i', strtotime($time_in)), $array_time)) {
                return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Time false!']);
            }

            if (strtotime($time_in) >= strtotime($time_out)) {
                return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Thời gian kết thúc phải lớn hơn thời gian vào!']);
            }

            $check_time = $this->CalendarDetail->find('first',[
                'conditions' => [
                    'OR' => [
                        'CalendarDetail.time' => date('Y-m-d G:i:s', strtotime($time_out)),
                        'CalendarDetail.time' => date('Y-m-d G:i:s', strtotime($time_in))
                    ],
                ]
            ]);

            if (!empty($check_time)) {
                return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Mù à không thấy có người đặt giờ này oy à. Óc quẹo!']);
            }

            $this->Transaction->begin();
            //Save calendar
            $this->Calendar->create();
            $result = $this->Calendar->save(['users_id' => $this->Auth->user('id'), 'time_in' => date('Y-m-d G:i:s', strtotime($time_in)), 'time_out' => date('Y-m-d G:i:s', strtotime($time_out))]);

            // Save  times calendar detail
            $array_times = [];
            for($i = strtotime($time_in) + $time_plus ; $i <= strtotime($time_out); $i += $time_plus) {

                $check_time2 = $this->CalendarDetail->find('first',[
                    'conditions' => [
                        'CalendarDetail.time' => date('Y-m-d G:i:s', $i),
                    ]
                ]);
                if (!empty($check_time2)) {

                    $this->Transaction->rollback();
                    return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Mù à không thấy có người đặt giờ này oy à. Óc quẹo!']);
                }
                // Save CalendarDetail
                if($i < strtotime($time_out)) {
                    $array_times[] = $i;
                    $this->CalendarDetail->create();
                    $resultDetail[] = $this->CalendarDetail->save(['calendars_id' => $result['Calendar']['id'], 'time' => date('Y-m-d G:i:s', $i)]);
                }
            }

            if (count($array_times) == count($resultDetail)) {
                $this->Transaction->commit();
                return $this->_trueJson(['message' => 'Save calendar success']);
            }

            $this->Transaction->rollback();
            return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Save calendar false!']);
        }
    }

    public function edit() {

        $this->layout = false;
        $this->autoRender = false;

        if($this->request->is('post')) {
            $id = $this->request->data['id'];
            $time_in = $this->request->data['time_in_date'].' '.$this->request->data['time_in_time'];
            $time_out = $this->request->data['time_in_date'].' '.$this->request->data['time_out_time'];
            $time_plus = 15 * 60;
            $array_time = [0, 15, 30, 45];

            if (!in_array(date('i', strtotime($time_in)), $array_time) || !in_array(date('i', strtotime($time_out)), $array_time) ) {
                return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Time false!']);
            }

            if (strtotime($time_in) >= strtotime($time_out)) {
                return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Thời gian kết thúc phải lớn hơn thời gian vào!']);
            }

            $check_time = $this->CalendarDetail->find('first',[
                'conditions' => [
                    'CalendarDetail.calendars_id !=' => $id,
                    'OR' => [
                        'CalendarDetail.time' => date('Y-m-d G:i:s', strtotime($time_out)),
                        'OR' => [
                            'CalendarDetail.time' => date('Y-m-d G:i:s', strtotime($time_in))
                        ]
                    ]
                    
                ]
            ]);

            // debug($check_time); die;
            if (!empty($check_time)) {
                return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Mù à không thấy có người đặt giờ này oy à. Óc quẹo!']);
            }

            $calendar = $this->Calendar->findById($id);

            if ($calendar) {

                $this->CalendarDetail->updateAll(
                    ['CalendarDetail.check' => 1],
                    ['CalendarDetail.calendars_id' => $id]
                );

                $this->Transaction->begin();
                $array_times = [];

                for($i = strtotime($time_in) + $time_plus ; $i <= strtotime($time_out); $i += $time_plus) {

                    $check_time2 = $this->CalendarDetail->find('first',[
                        'conditions' => [
                            'CalendarDetail.calendars_id !=' => $id,
                            'CalendarDetail.time' => date('Y-m-d G:i:s', $i),
                        ]
                    ]);
                    if (!empty($check_time2)) {

                        $this->Transaction->rollback();
                        return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Mù à không thấy có người đặt giờ này oy à. Óc quẹo!']);
                    }
                    // Save CalendarDetail
                    if($i < strtotime($time_out)) {
                        $array_times[] = $i;
                        $this->CalendarDetail->create();
                        $resultDetail[] = $this->CalendarDetail->save(['calendars_id' => $id, 'time' => date('Y-m-d G:i:s', $i)]);
                    }
                }

                if (count($array_times) == count($resultDetail)) {
                    $this->CalendarDetail->deleteAll(
                        ['CalendarDetail.check' => 1],
                        ['CalendarDetail.calendars_id' => $id]
                    );
                    $this->Calendar->save(['id' => $id, 'time_in' => date('Y-m-d G:i:s', strtotime($time_in)), 'time_out' => date('Y-m-d G:i:s', strtotime($time_out))]);
                    $this->Transaction->commit();
                    return $this->_trueJson(['message' => 'Edit booking success']);
                }

                $this->Transaction->rollback();
                return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Edit booking false!']);
            }
        }

        $id = $this->request->query['id'];
        $data = $this->Calendar->find('first', [
            'conditions' => [
                'Calendar.id' => $id,
                'Calendar.users_id' => $this->Auth->user('id')
            ]
        ]);
        if ($data) {
            $response = [];
            $response['day'] = date('Y-m-d', strtotime($data['Calendar']['time_in']));
            $response['time_in'] = date('h:i A', strtotime($data['Calendar']['time_in']));
            $response['time_out'] = date('h:i A', strtotime($data['Calendar']['time_out']));
            return $this->_trueJson($response);
        }
        return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Data null!']);
    }

    /**
     *
     */

    public function remove() {
        $this->autoRender = false;
        if($this->request->is('ajax')){
            $id = $this->request->data['id'];
            if($id) {
                $re_detail = $this->CalendarDetail->deleteAll(['calendars_id' => $id], false);
                $result = $this->Calendar->delete($id);
                if($result) {
                    return $this->_trueJson(['message' => 'Delete success !']);
                } else {
                    return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Remove false!']);
                }
            } else {
                return $this->_falseJson(Constants::BAD_REQUEST, null, ['message' => 'Data null!']);
            }
        }
        
    }
}