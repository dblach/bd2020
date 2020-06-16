<?php
	include "polaczenie.php";
	$idl=$_GET['idl'];
	$idt=$_GET['idt'];
	$q=mysqli_query($l,"delete from terminy_przyjec where id_terminu=$idt");
	
	echo "Wybrany termin został usunięty.";
	echo "<br><a href=\"terminy_lekarza.php?idl=$idl\"><button type=\"button\">OK</button></a>";
?>