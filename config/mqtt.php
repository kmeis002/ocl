<?php
/**
 * Created by PhpStorm.
 * User: salman
 * Date: 2/22/19
 * Time: 1:29 PM
 */

return [

    'host'     => env('mqtt_host','127.0.0.1'),
    'password' => env('mqtt_password','testing'),
    'username' => env('mqtt_username','ocl'),
    'certfile' => env('mqtt_cert_file',''), //Maybe implement certs eventually...you can do it.
    'port'     => env('mqtt_port','1883'),
    'debug'    => env('mqtt_debug',false), //Optional Parameter to enable debugging set it to True
    'qos'      => env('mqtt_qos', 0), // set quality of service here
    'retain'   => env('mqtt_retain', 0) // it should be 0 or 1 Whether the message should be retained.- Retain Flag
];
