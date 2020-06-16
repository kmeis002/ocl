import paho.mqtt.client as mqttc
import logging
import vmvisor
import re
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
| -responses to api to confirm actions
| -add tls support since this will be used to transmit rotating flags to vms
| -unit tests for listeners
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
	payload = sanitize(str(msg.payload).strip('b\''))

	print("message received on " + msg.topic + " says " + payload)
	try:
		vms = vmvisor.vmvisor()
	except Exception as log_msg:
		logging.error(log_msg)

	if(msg.topic == 'vm/import'):
		logging.info('Attempting to import ' + payload + '.')
		try:
			vms.importVM(payload)
			logging.info("VM " + payload + " imported.")	
		except Exception as log_msg:
			logging.error(log_msg)

	if(msg.topic == 'vm/unregister'):
		logging.info('Attempting to unregister ' + payload + '.')
		try:
			vms.unregisterVM(payload)
			logging.info('VM ' + payload + ' unregistered.')
		except Exception as log_msg:
			logging.error(log_msg)

	if(msg.topic == 'vm/start'):
		logging.info('Attempting to start ' + payload + '.')
		try:
			vms.startVM(payload)
			logging.info(payload + ' started.')
		except Exception as log_msg:
			logging.error(log_msg)

	if(msg.topic == 'vm/stop'):
		logging.info('Attempting to stop ' + payload + '.')
		try:
			vms.stopVM(payload)
			logging.info(payload + ' stopped.')
		except Exception as log_msg:
			logging.error(log_msg)

	if(msg.topic == 'vm/reset'):
		logging.info('Attempting to start ' + payload + '.')
		try:
			vms.resetVM(payload)
			logging.info(payload + ' has been reset.')
		except Exception as log_msg:
			logging.error(log_msg)

	#msg format name,mode
	if(msg.topic == 'vm/modifyNIC'):
		if(len(payload.split(',')) == 2):
			name = payload.split(',')[0]
			mode = payload.split(',')[1]
			logging.info('Attempting to change NIC of ' + name + '.')
			try:
				vms.modifyNIC(name, mode)
				logging.info('NIC 1 of ' + name + ' has been changed to ' + mode + '.')
			except Exception as log_msg:
				logging.error(log_msg)
		else:
			logging.error('vm/modifyNIC message must be of the form <machine name>,<NIC mode>.')

	#msg format name,dev
	if(msg.topic == 'vm/modifyBridged'):
		if(len(payload.split(',')) == 2):
			name = payload.split(',')[0]
			dev = payload.split(',')[1]
			logging.info('Attempting to change Bridge Network Adapter of ' + name + '.')
			try:
				vms.modifyBridgeAdapter(name, dev)
				logging.info('Network Adapter of ' + name + ' has been changed to ' + dev + '.')
			except Exception as log_msg:
				logging.error(log_msg)
		else:
			logging.error('vm/modifyBridged message must be of the form <machine name>,<device name>.')

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

#Removes all characters but a-z A-z 0-9 , - _ ? ! $ 
def sanitize(usr_input):
	if(not type(usr_input) == str):
		print('only sanitizes a string')
		return
	return re.sub(r'[^\w,$~!-]', '', usr_input)






def main(log_level):
	logging.basicConfig(filename="/var/www/html/devel/ocl/storage/logs/mqtt.log", format='%(asctime)s %(levelname)-8s %(message)s', level=log_level, datefmt='%Y-%m-%d %H:%M:%S')
	logging.info('MQTT Listener Started')
	client = setup_listener('ocl','testing','localhost');
	client.loop_forever()

main(logging.DEBUG)