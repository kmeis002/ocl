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
| - Add Requests to API to relay success messages and modify VM Model states in DB
| - Allow for multiple NIC modifications (intnet?)
|
'''

class vmvisor:
	def __init__(self):
		self.location="/var/www/html/devel/ocl/storage/app/vm/"
		self.modes = ['nat', 'bridged', 'intnet', 'hostonly']
		if(not os.path.exists(self.location)):
			raise Exception('ova location doesn\'t exist')

	def __enter__(self):
		return self

	def importVM(self, name):
		#Raise errors
		if(self.exists(name)):
			raise Exception('VM already registered')
		if(not os.path.exists(self.location+name+'.ova')):
			raise Exception(name + '.ova file not found in ' + self.location + '.')

		import_cmd = ['vboxmanage', 'import', self.location + name +'.ova']
		proc = cmd.run(import_cmd, capture_output=True)

		if(proc.returncode != 0 or not self.exists(name)):
			raise Exception('VM could not be imported.\n' + self.bytesToStr(proc.stderr))

	def unregisterVM(self, name):
		if(not self.exists(name)):
			raise Exception('VM ' + name + ' is not registered.')

		if(self.isActive(name)):
			self.stopVM(name)

		unreg_cmd = ['vboxmanage', 'unregistervm', name, '-delete']
		proc = cmd.run(unreg_cmd, capture_output=True)

		if(proc.returncode != 0 or self.exists(name)):
			raise Exception('VM ' + name + ' could not be unregistered.\n' + self.bytesToStr(proc.stderr))

	def startVM(self, name):
		if(not self.exists(name)):
			raise Exception('VM ' + name + ' is not registered.')
		if(self.isActive(name)):
			raise Exception('VM ' + name + ' is already active.')

		start_cmd = ['vboxmanage', 'startvm', name, '--type', 'headless']
		proc = cmd.run(start_cmd, capture_output=True)

		if(proc.returncode != 0 or not self.isActive(name)):
			raise Exception('VM ' + name + ' failed to activate.\n'+self.bytesToStr(proc.stderr))

	def stopVM(self,name):
		if(not self.exists(name)):
			raise Exception('VM ' + name + ' is not registered.')
		if(not self.isActive(name)):
			raise Exception('VM ' + name + ' is already disabled.')

		stop_cmd = ['vboxmanage', 'controlvm', name, 'poweroff']
		proc = cmd.run(stop_cmd, capture_output=True)

		if(proc.returncode != 0 or self.isActive(name)):
			raise Exception('VM ' + name + ' failed to activate.\n' + self.bytesToStr(proc.stderr))

	def resetVM(self,name):
		if(not self.exists(name)):
			raise Exception('VM ' + name + ' is not registered.')
		if(not self.isActive(name)):
			raise Exception('VM ' + name + ' is inactive, cannot be reset.')

		start_cmd = ['vboxmanage', 'controlvm', name, 'reset']
		proc = cmd.run(start_cmd, capture_output=True)

		if(proc.returncode != 0):
			raise Exception('VM ' + name + ' failed to reset.\n' + self.bytesToStr(proc.stderr))	

	def modifyNIC(self, name, mode):
		if(not self.exists(name)):
			raise Exception('VM ' + name + ' is not registered')
		if(self.isActive(name)):
			raise Exception('VM ' + name + ' must be powered off before modification.')
		if(mode not in self.modes):
			raise Exception('Mode ' + mode + ' is not an acceptable VirtualBox Networking option.')
		modify_cmd = ['vboxmanage', 'modifyvm', name, '--nic1', mode]
		proc = cmd.run(modify_cmd, capture_output=True)

		if(proc.returncode != 0 or mode not in self.getNetworkInfo(name)):
			raise Exception('NIC 1 failed to set to ' + mode + ' mode on ' + name +  '.\n' + self.bytesToStr(proc.stderr))

	def modifyBridgeAdapter(self, name, dev):
		if(not self.exists(name)):
			raise Exception('VM ' + name + ' is not registered')
		if(self.isActive(name)):
			raise Exception('VM ' + name + ' must be powered off before modification.')
		if("bridged" not in self.getNetworkInfo(name)):
			raise Exception('VM ' + name + ' NIC must be set to bridged mode.')
		if(dev not in self.getNetworkInterfaces()):
			raise Exception('Network interface: ' + dev + ' not found on system.')


		modify_cmd = ['vboxmanage', 'modifyvm', name, '--bridgeadapter1', dev]
		proc = cmd.run(modify_cmd, capture_output=True)

		if(proc.returncode != 0 or dev not in self.getNetworkInfo(name)):
			raise Exception('NIC 1 failed to set to ' + dev + ' mode on ' + name  +'.\n' + self.bytesToStr(proc.stderr))

    #Helper functions
	def exists(self, name):
		output = cmd.run(['vboxmanage', 'list', 'vms'], capture_output=True).stdout
		return str(name) in str(output)

	def isActive(self, name):
		output = cmd.run(['vboxmanage', 'list', 'runningvms'], capture_output=True).stdout
		return str(name) in str(output)

	#Returns NIC mod and networking device used by machine (name)
	def getNetworkInfo(self, name):
		mode = ''
		dev = ''
		output = cmd.run(['vboxmanage', 'showvminfo', name], capture_output=True).stdout
		for m in self.modes:
			if(m in str(output).lower()):
				mode = m
		dev_list = self.getNetworkInterfaces()
		for d in dev_list:
			if(d in str(output).lower()):
				dev = d

		return [mode, dev]

	#Returns a list of system devices (linux)
	def getNetworkInterfaces(self):
		output = []
		dev_list = str(cmd.run(['cat', '/proc/net/dev'], capture_output=True).stdout).strip('b\'').split(':')[1:]
		for line in dev_list:
			output.append(line.split('\\n')[1].strip(' '))


		return output[:-1]

	def bytesToStr(self, bytes):
		return str(bytes).strip('b\'')




	

