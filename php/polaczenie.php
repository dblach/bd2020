<?php
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);

	$host='localhost';
	$user='root';
	$password='';
	$database='przychodnia';
	
	$l=new mysqli($host,$user,$password,$database);
	if($l->connect_error) die('Błąd połączenia');
?>