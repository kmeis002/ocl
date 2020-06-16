import paho.mqtt.client as mqttc
from datetime import datetime
import time
import logging
import os
import signal

#this code is awful, but it works (maybe???)

#To Do:
#vboxmanage class to run process
#responses to api to confirm actions

#Listener class
class MQTTListener:

	#create and connect
	def __init__(self, log_level):
		user='ocl'
		passwd = 'testing'
		host = 'localhost'
		port = '1883'
		log_file = '/var/www/html/devel/ocl/storage/logs/mqtt.log'

		logging.basicConfig(filename=log_file, level=log_level)

		self.client = mqttc.Client("ocl_listener")
		self.client.username_pw_set(user,passwd)

		

		self.client.connect(host)
		self.client.subscribe('srv/vm')

		#set callbacks
		self.client.on_connect=self.on_connect
		self.client.on_disconnect=self.on_disconnect
		self.client.on_message=self.on_message

		self.client.subscribe('srv/vm')

	def __enter__(self):
		return self

	def on_disconnect(self, client, userdata, rc):
	    logging.info(self.make_log("OCL_MQTT Listener disconnected: code = "+str(rc)))
	    self.client.connected_flag=False
	    self.client.disconnect_flag=True

	def on_connect(self, client, userdata, flags, rc):
		if rc==0:
			self.client.connected_flag=True
			logging.info(self.make_log("Connection Established: code = " + str(rc)))
		else:
			logging.warn(self.make_log("Could not connect to MQTT Server: code = " + str(rc)))
		time.sleep(2)

	def on_message(client, userdata, msg):
		print("Message received from: " + msg.topic  + " says " + str(msg.payload))
		logging.info("Message Received")	


	def start(self):
		self.client.loop_forever()

	def publish(self, topic, message):
		logging.info(self.make_log("Message Published to topic = " + topic))
		self.client.publish(topic,message)


	def make_log(self, message):
		timestamp = datetime.now().strftime('%m-%d-%Y %H:%M:%S')
		if(type(message) == str):
			return timestamp + " | " + message
		return timestamp + " | " + "Message was not formatted as a string"

	def __exit__(self, exc_type, exc_value, traceback):
		self.client.loop_stop()
		self.client.disconnect()

with MQTTListener(logging.DEBUG) as mqtt_listener:
	mqtt_listener.start()