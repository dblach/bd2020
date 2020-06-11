<?php
	include "polaczenie.php";
	include "redirect.php";
	$idl=$_GET['idl'];
	$q=mysqli_query($l,"delete from lekarze where id_lekarza=$idl");
	redirect("wybierz_lekarza.php");
?>