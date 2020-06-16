import paho.mqtt.client as mqttc
from datetime import datetime
import time
import logging
import os
import vmvisor

'''
|--------------------------------------------------------------------------
| ocl_mqtt
|--------------------------------------------------------------------------
|
| Python script to poll mqtt for services invoked via VMVisorController api
| Its pretty poorly coded and will be loaded as a service
| 
|
| To Do:
|
| -vboxmanage class to run process
| -responses to api to confirm actions
| -add simple sanitiziation for possible cmd injection for subprocess. [Whitelist only a-z A-Z 0-9 -_ ]
|
'''
def setup_listener(user, passwd, host):
	client = mqttc.Client("ocl_listener")
	client.username_pw_set(user,passwd)

		
	client.connect(host)
	client.on_connect=on_connect
	client.on_disconnect=on_disconnect
	client.on_message=on_message

	client.subscribe('vm/#') #Multiple topics to import, modify, start, stop, restart, and unregister machines
	return client

def on_message(client, userdata, msg):
	name = str(msg.payload).strip('b\'')
	try:
		vms = vmvisor.vmvisor()
	except Exception as log_msg:
		logging.error(log_msg)

	if(msg.topic == 'vm/import'):
		logging.info('Attempting to import ' + name + '.')
		try:
			vms.importVM(name)
			logging.info("VM " + name + " imported.")	
		except Exception as log_msg:
			logging.error(log_msg)


	if(msg.topic == 'vm/unregister'):
		logging.info('Attempting to unregister ' + name + '.')
		try:
			vms.unregisterVM(name)
			logging.info('VM ' + name + ' unregistered.')
		except Exception as log_msg:
			logging.error(log_msg)

	if(msg.topic == 'vm/start'):
		logging.info('Attempting to start ' + name + '.')
		try:
			vms.startVM(name)
		except Exception as log_msg:
			logging.error(log_msg)

	if(msg.topic == 'vm/stop'):
		logging.info('Attempting to stop ' + name + '.')
		try:
			vms.stopVM(name)
		except Exception as log_msg:
			logging.error(log_msg)

	if(msg.topic == 'vm/reset'):
		logging.info('Attempting to start ' + name + '.')
		try:
			vms.resetVM(name)
		except Exception as log_msg:
			logging.error(log_msg)


	del vms

	


def on_connect(client, userdata, flags, rc):
	if rc==0:
		client.connected_flag=True
		logging.info(make_log("Connection Established: code = " + str(rc)))
	else:
		logging.warn(make_log("Could not connect to MQTT Server: code = " + str(rc)))
		time.sleep(2)

def on_disconnect(client, userdata, rc):
	    logging.info(make_log("OCL_MQTT Listener disconnected: code = "+str(rc)))
	    client.connected_flag=False
	    client.disconnect_flag=True




def main(log_level):
	logging.basicConfig(filename="/var/www/html/devel/ocl/storage/logs/mqtt.log", format='%(asctime)s %(levelname)-8s %(message)s', level=log_level, datefmt='%Y-%m-%d %H:%M:%S')
	logging.info('MQTT Listener Started')
	client = setup_listener('ocl','testing','localhost');
	client.loop_forever()

main(logging.DEBUG)