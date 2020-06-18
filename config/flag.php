<?php
/*
| Flag rotation configuration file.
*/

return [
	'rotate' => env('flag_rotate', true),
	'time' 	 => env('flag_time', 0),
	'random' => env('flag_random', 16),
];
