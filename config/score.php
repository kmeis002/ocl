<?php
/*
| Score configuration file
*/

return [
	'user_weight' => env('score_user', 0.5),     //user weight for B2R machines (points*weight)
	'root_weight' 	 => env('score_root', 1.0),  //root weight for B2R machines
	'level_scale' => env('score_level', 1.0),       //Level scale: 1=each level is equal weighting
	'b2r_weight' => env('score_b2r'),			//b2r weight for total_score
	'lab_weight' =>	env('score_lab'),
	'ctf_weight' => env('score_ctf')
];
