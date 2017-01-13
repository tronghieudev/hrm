<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/7/2016
 * Time: 3:15 PM
 */
$config = [];
class Constants {

    // status
    const OK = 200;
    const BAD_REQUEST = 400;
    // roles
    const ADMIN = 1;
    const USER = 2;

    // gender
    const GENDER = [0 => 'FeMale', 1 => 'Male'];

    // url upload file
    const AVATA_URL = 'img/avata/';
    const CV_URL = 'files/cv/';

    // type overtime
    const TYPE_DAY_NORMAL = 1;
    const TYPE_DAY_OFF = 2;
    const TYPE_HOLIDAY = 3;


    // status 
    const STATUS_LIVE =1;

}