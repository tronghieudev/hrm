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
}