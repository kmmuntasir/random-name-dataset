<?php
	
	session_start();
	require('db.php');
	require('app/library/lib.php');

	// Getting root path
	$protocol = (isset($_SERVER['REQUEST_SCHEME'])) ? $_SERVER['REQUEST_SCHEME'] : (explode(':/', $_SERVER['SCRIPT_URI'])[0]);
	$index_path = $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];

	$_SESSION['rootpath'] = substr($index_path, 0, strrpos($index_path, '/')+1);

	$_SESSION['controller_path'] 	= 'app/controller/';
	$_SESSION['model_path'] 		= 'app/model/';
	$_SESSION['library_path'] 		= 'app/library/';
	$_SESSION['view_path'] 			= 'app/view/';

	$_SESSION['default_controller'] = 'main';


	library('l_common');
	library('l_url');
	library('l_db');

?>
