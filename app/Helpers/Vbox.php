<?php
namespace app\Helpers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

/*
|--------------------------------------------------------------------------
| Vbox Helper
|--------------------------------------------------------------------------
|
| Class to be used as a Facade to verify vboxmanage states so VM model
| isn't so cluttered. Uses subprocess to call vboxmanage commands to verify
| VM states/properties are in line the DB models.
| (Ideally, no user input is directly passed to sub process. If needed, simple regex santization function required)
| 
| To Do:
| - add regex sanitization for user inputs (IP, machine names)
|
*/

class Vbox{


	//returns all registeredVMs
	public function getAllVMs(){
		$process = new Process(['vboxmanage', 'list', 'vms']);

  	$process->run();

  	return $process->getOutput();
	}

  	//Return specific VM by name
  	public function getVM($name){
  		$vm_list = $this->getAllVms();

  		if(!strpos($vm_list, $name)){
  			return false;
  		}

  		$vm_list = explode(PHP_EOL, $vm_list);

  		foreach($vm_list as $machine){
  			if(is_int(strpos($machine, $name))){
  				return $machine;
  			}
  		}
  	}

  	public function isRegistered($name){
  		$vm_list = $this->getAllVms();
  		return (strpos($vm_list, $name) !== false);
  	}

    //returns VM network interface
    public function getNetworkInterface($name, $nic){
      $info = $this->vmInfo($name);

      $info = explode(PHP_EOL, $info);

      foreach($info as $line){
          if (strpos($line, $nic) !== false){
            return explode(',',explode(':', $line)[3])[0];
          }
      }
      return $nic.' not found';
    }

    //returns an array of all possible machine interfaces (for verification purposes) [jank]
    public function getHostInterfaces(){
      $process = new Process(['ip', 'link', 'show']);

      $process->run();

      $net_list = explode(PHP_EOL, $process->getOutput());
      $out = array();

      for($i = 0; $i < sizeof($net_list)-2; $i=$i+2){
         array_push($out, trim(explode(':', $net_list[$i])[1], ' '));
      }

      return $out;


    }

    //vbox process runs under different user, cannot see runningvms. ping to verify host is up...but will implement a better way (maybe)
  	public function isRunning($ip){
  	   $process = new Process(['ping', '-c', '1', $ip]);

       $process->run();

       return (strpos($process->getOutput(), '1 received') !== false);
  	}

  	public function ovaExists($name){
  		return Storage::exists('/vm/'.$name.'.ova');
  	}

  	//sanitize input !!!
  	public function vmInfo($name){
		$process = new Process(['vboxmanage', 'showvminfo', $name]);

  		$process->run();

  		return $process->getOutput();
  	}



}
