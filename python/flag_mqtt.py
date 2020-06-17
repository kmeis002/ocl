import paho.mqtt.client as mqttc
import sys
import subprocess
import logging
import os
import re
'''
|--------------------------------------------------------------------------
| flag_mqtt.py
|--------------------------------------------------------------------------
|
| Python script to receive flag changes if rotations are turned on. To be used
| locally on Boot2Root (B2R) machines and Labs as a service. Must have mqtt svc
| active on VirtualBox bridged network.
|
| To Do:
|
| -responses to api to confirm actions
| -add tls support since this will be used to transmit rotating flags to vms
| -Install script (checks for python3, python3-pip, paho-mqtt, mosquitto-clients 
|   | makes mqtt user  | finds user/root flags OR level setup | changes privs of flag file (w only to mqtt) 
|   | sets up systemctl modules and enables )
| 
'''
def setup_listener(user, passwd, host):
	client = mqttc.Client("flag_listener")
	client.username_pw_set(user,passwd)

	client.connect(host)
	client.on_connect=on_connect
	client.on_disconnect=on_disconnect
	client.on_message=on_message

	client.subscribe(os.uname()[1]+'/#') #Subscribe to local machine topics for root, user, level flags
	return client

def on_message(client, userdata, msg):
	#Change these to fit your machine.
	root_path = '/root/root.txt'
	user_path = '/home/{}/user.txt'
	level_path = '/home/levels_test/{}/flag.txt'

	#sanitize input
	payload = sanitize(str(msg.payload).strip('b\''))
	machine = os.uname()[1]
	print("message received on " + msg.topic + " says " + payload)

	#write root flag
	if('root' in msg.topic):
		logging.info('Writing root flag.')
		try:
			write_flag(root_path, payload)
		except Exception as log_msg:
			logging.error(log_msg)

	#write user flag
	if('user' in msg.topic):
		logging.info('Writing user flag.')
		#auto_find userflag in home folder. You can add the direct path if you want to speed things up
		user_path = str(subprocess.run(['find','/home/', '-name', 'user.txt'], capture_output=True).stdout).strip('b\'\\n')
		try:
			write_flag(user_path, payload)
		except Exception as log_msg:
			logging.error(log_msg)

	#write level flag: fmt should be topic: '{machine}/level{#}' 
	if('level' in msg.topic):
		num = re.sub(r'[^\d]', '', msg.topic.split('/')[1])
		logging.info('Writing level ' + num + 'flag.')
		try:
			write_flag(level_path.format(get_level_user('/home/levels_test') + num), payload)
		except Exception as log_msg:
			logging.error(log_msg)

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

#assumes levels are located in homefolders for labs
def calculate_levels():
	return len(str(subprocess.run(['ls', '/home/'], capture_output=True).stdout).strip('b\'').split('\\n'))-1

#assumes levels in labs are in home folders with the same user name + level number: "user1", "user2", ...
def get_level_user(path):
		user_list = str(subprocess.run(['ls', path], capture_output=True).stdout).strip('b\'').split('\\n')[:-1]
		output = re.sub(r'[\d]', '', user_list[0])
		for user in user_list:
			chk = re.sub(r'[\d]', '', user)
			if chk != output:
				raise exception('Home folder found with a non-patterned username.')

		return output


#write to appropriate flag location (payload = md5sum)
def write_flag(path, flag):
	if(not os.path.exists(path)):
		raise Exception('Flag location not found at ' + path + '. Modify local flagrotate file.')

	with open(path, "r+") as f:
			f.seek(0)
			f.write(flag + '\n')
			f.truncate()

def main(log_level):
	if(len(sys.argv) < 2):
		print('Please enter an mqtt host to connect to. [python3 flag_mqtt.py <host ip>')
	else:
		logging.basicConfig(filename="/var/log/flagrotate.log", format='%(asctime)s %(levelname)-8s %(message)s', level=log_level, datefmt='%Y-%m-%d %H:%M:%S')
		logging.info('MQTT Listener Started')
		client = setup_listener('ocl','testing',sys.argv[1])
		client.loop_forever()

main(logging.DEBUG)