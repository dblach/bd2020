<?php
	include "polaczenie.php";
	include "redirect.php";
	$idl=$_POST['idl'];
	$imie=$_POST['imie'];
	$nazwisko=$_POST['nazwisko'];
	$q=mysqli_query($l,"update lekarze set imie=\"$imie\",nazwisko=\"$nazwisko\" where id_lekarza=$idl");
	redirect("wybierz_lekarza.php");
?>