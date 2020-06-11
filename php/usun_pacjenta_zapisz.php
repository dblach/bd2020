<?php
	include "polaczenie.php";
	include "redirect.php";
	$idp=$_GET['idp'];
	$q=mysqli_query($l,"delete from pacjenci where id_pacjenta=$idp");
	redirect("wybierz_pacjenta.php?target=edytuj_pacjenta.php?");
?>