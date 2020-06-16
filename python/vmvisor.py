import os
import requests
import subprocess as cmd

'''
|--------------------------------------------------------------------------
| vmvisor.py
|--------------------------------------------------------------------------
|
| Python class to be used in ocl_mqtt to controll vboxmanage for common tasks
| Polls OCL API to determine database stats and MQTT to get commands from
| the API.
|
| To-Do:
| - Fix logging
| - Compelete importVM with more error checking (throw errors)
| - Complete unregisterVM with error checking
| - Complete startVM, stopVM, restartVM
| - Complete modifyVM Methods (change netinterface, mac add(?), change network )
|
'''

class vmvisor:
	def __init__(self):
		self.location="/var/www/html/devel/ocl/storage/app/vm/"
		if(not os.path.exists(self.location)):
			raise Exception('ova location doesn\'t exist')

    #Check is virtual machine is already loaded
	def exists(self, name):
		output = cmd.run(['vboxmanage', 'list', 'vms'], capture_output=True).stdout
		return str(name) in str(output)

	def isActive(self, name):
		output = cmd.run(['vboxmanage', 'list', 'runningvms'], capture_output=True).stdout
		return str(name) in str(output)

	def importVM(self, name):
		#Raise errors
		if(self.exists(name)):
			raise Exception('VM already registered')
		if(not os.path.exists(self.location+name+'.ova')):
			raise Exception('OVA file not found')

		import_cmd = ['vboxmanage', 'import', self.location + name +'.ova']
		proc = cmd.run(import_cmd)

		if(proc.returncode != 0 or not self.exists(name)):
			raise Exception('VM could not be imported')

	def unregisterVM(self, name):
		if(not self.exists(name)):
			raise Exception('VM ' + name + ' is not registered.')

		unreg_cmd = ['vboxmanage', 'unregistervm', name, '-delete']
		proc = cmd.run(unreg_cmd)

		if(proc.returncode != 0 or self.exists(name)):
			raise Exception('VM ' + name + ' could not be unregistered.')

	def startVM(self, name):
		if(not self.exists(name)):
			return Exception('VM ' + name + ' is not registered.')
		if(self.isActive(name)):
			return Exception('VM ' + name + ' is already active.')

		start_cmd = ['vboxheadless', '-s', name]
		proc = cmd.run(start_cmd)

		if(proc.returncode != 0 or self.isActive(name)):
			return Exception('VM ' + name + ' failed to activate.')

	def stopVM(self,name):
		if(not self.exists(name)):
			return Exception('VM ' + name + ' is not registered.')
		if(not self.isActive(name)):
			return Exception('VM ' + name + ' is already disabled.')

		stop_cmd = ['vboxmanage', 'controlvm', name, 'poweroff']
		proc = cmd.run(stop_cmd)

		if(proc.returncode != 0 or self.isActive(name)):
			return Exception('VM ' + name + ' failed to activate.')

	def resetVM(self,name):
		if(not self.exists(name)):
			return Exception('VM ' + name + ' is not registered.')
		if(self.isActive(name)):
			return Exception('VM ' + name + ' is already active.')

		start_cmd = ['vboxmanage', 'controlvm', name, 'restart']
		proc = cmd.run(start_cmd)

		if(proc.returncode != 0):
			return Exception('VM ' + name + ' failed to reset')		


