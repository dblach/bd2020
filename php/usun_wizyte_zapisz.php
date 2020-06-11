<?php
	include "polaczenie.php";
	include "redirect.php";
	$idw=$_GET['idw'];
	$t=str_replace("'","",$_GET['target']);
	$q=mysqli_query($l,"delete from wizyty where id_wizyty=$idw");
	//redirect($t);
	redirect("index.php");
?>