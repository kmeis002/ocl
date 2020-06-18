<?php
/*
| MQTT Configuration files
*/

return [
	'host' => env('mqtt_host', 'localhost'),
	'port' => env('mqtt_port', 1883),
	'cert' => env('mqtt_cert', ''),
	'user' => env('mqtt_user', 'ocl'),
	'pass' => env('mqtt_pass', 'testing'),
	'qos'  => env('mqtt_qos', 0),
	'retain' => env('mqtt_retain', 0)
];
