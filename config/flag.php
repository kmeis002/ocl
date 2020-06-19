<?php
/*
| Flag rotation configuration file.
*/

return [
	'rotate' => env('flag_rotate', true),
	'time' 	 => env('flag_time', 0),
	'on_submit' => env('flag_on_submit', true),
	'random' => env('flag_random', 16),
];
