<?php
	include "polaczenie.php";
	include "redirect.php";
	$idw=$_GET['idw'];
	$idl=$_GET['idl'];
	$q=mysqli_query($l,"update wizyty set id_lekarza=$idl,data=\"1000-01-01\",godzina_rozpoczecia=\"00:00:00\",godzina_zakonczenia=\"00:00:00\" where id_wizyty=$idw");
	redirect("edytuj_wizyte.php?idw=$idw");
?>