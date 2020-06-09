<?php
	function redirect($a){
		$addr="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		header("Location: ".substr($addr,0,strrpos($addr,'/')).'/'.$a);
	}
?>