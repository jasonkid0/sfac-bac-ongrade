<?php

    // $server = 'localhost';
	// $username = 'u733437513_lorenzo';
	// $password = 'Hw#7vmG4[H';
	// $dbd = 'u733437513_enrollmentbac';
	
	
	$server = 'localhost';
	$username = 'root';
	$password = '';
	$dbd = 'enrollmentbac';

	$db = new mysqli($server, $username, $password, $dbd);

	date_default_timezone_set('Asia/Manila');

?>