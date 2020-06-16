<?php
	include "polaczenie.php";
	$idl=$_GET['idl'];
	$idu=$_GET['idu'];
	$q=mysqli_query($l,"delete from urlopy where id_urlopu=$idu");
	
	echo "Wybrany urlop został usunięty.";
	echo "<br><a href=\"urlopy_lekarza.php?idl=$idl\"><button type=\"button\">OK</button></a>";
?>