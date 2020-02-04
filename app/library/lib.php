<?php
	
	function controller($controller_filename = null) {
		if(!$controller_filename) 
			$controller_filename = $_SESSION['default_controller'];
		require($_SESSION['controller_path'].$controller_filename.'.php');
	}

	function model($model_filename) {
		require($_SESSION['model_path'].$model_filename.'.php');
	}

	function library($library_filename) {
		require($_SESSION['library_path'].$library_filename.'.php');
	}

	function view($view_filename, $data=null) {
		$themepath = $_SESSION['rootpath'].$_SESSION['view_path'];
		extract($data);
		unset($data);
		require($_SESSION['view_path'].$view_filename.'.php');
	}

?>