<?php
	

	function site_link($page=null) {
		echo $_SESSION['rootpath'];
		if($page) echo 'index.php?page='.$page;
	}
?>