<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| Lab Model
|--------------------------------------------------------------------------
|
| Labs are VMs that contain levels verified with individual flags. While labs
| main table is 'vms', lab write/read from 'lab_flags' and 'hints' for display
| and user submissions
|
*/

class Lab extends VM{
    
    protected $hint_tbl = 'hints';
    protected $flag_tbl = 'lab_flags';

    //How many leves the lab contains (obtained by counting lab_flags table)
    protected $lvls;

}
