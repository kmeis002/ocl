<?php
/*
| Score configuration file
*/

return [
	'user_weight' => env('score_user', 0.5),     //user weight for B2R machines (points*weight)
	'root_weight' 	 => env('score_root', 1.0),  //root weight for B2R machines
	'level_weight' => env('score_level', 1.0),       //Level scale: 1=each level is equal, power exponent from 0->points
	'b2r_weight' => env('score_b2r', 1.0),			//b2r weight for total_score
	'lab_weight' =>	env('score_lab', 1.5),
	'ctf_weight' => env('score_ctf', 1.0),
	'hint_points' => env('score_hints', 3.0),
];
