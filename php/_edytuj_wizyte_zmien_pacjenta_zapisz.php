<?php
	include "polaczenie.php";
	include "redirect.php";
	$idw=$_GET['idw'];
	$idp=$_GET['idp'];
	$q=mysqli_query($l,"update wizyty set id_pacjenta=$idp where id_wizyty=$idw");
	redirect("edytuj_wizyte.php?idw=$idw");
?>