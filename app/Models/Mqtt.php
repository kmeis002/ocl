<?php

namespace App\Models;

use Bluerhinos\phpMQTT;

/*
|--------------------------------------------------------------------------
| MQTT
|--------------------------------------------------------------------------
| Wrapper for BlueRhinos phpMQTT.php. Configure in mqtt.php in config
|
*/



class Mqtt{

	protected $conn;
	protected $host;
	protected $port;
	protected $user;
	protected $pass;
	protected $cert;
	protected $qos;
	protected $retain;

	public function __construct()
	{
		$this->host = config('mqtt.host');
		$this->port = config('mqtt.port');
		$this->user = config('mqtt.user');
		$this->pass = config('mqtt.pass');
		$this->cert = config('mqtt.cert');
		$this->qos = config('mqtt.qos');
		$this->retain = config('mqtt.retain');
	}

	public function publish($topic, $msg){

		$conn = new phpMQTT($this->host, $this->port, 'ocl_mqtt_publisher');

		if($conn->connect(true, NULL, $this->user, $this->pass)){
			$conn->publish($topic, $msg, $this->qos, false);
			$conn->close();
			return true;
		}

		return false;

	}

	public function waitForResponse($topic){
		$conn = new phpMQTT($this->host, $this->port, 'ocl_mqtt_listener');

		if(!$conn->connect(true, NULL, $this->user, $this->pass)){
			exit(1);
		}

		$msg = $conn->subscribeAndWaitForMessage($topic, $this->qos);

		$conn->close();

		return $msg;
	}

}