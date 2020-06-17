<?php
	include "polaczenie.php";
	$idl=$_POST['idl'];
	$imie=$_POST['imie'];
	$nazwisko=$_POST['nazwisko'];
	
	if($idl!=0){
		$q=mysqli_query($l,"update lekarze set imie=\"$imie\",nazwisko=\"$nazwisko\" where id_lekarza=$idl");
	}
	else{
		$q=mysqli_query($l,"insert into lekarze(id_lekarza,imie,nazwisko) values(null,\"$imie\",\"$nazwisko\")");
		$idl=mysqli_fetch_array(mysqli_query($l,"select max(id_lekarza) from lekarze"))[0];
	}
	
	echo "Zmiany zostały zapisane.";
	echo "<br><a href=\"wybierz_lekarza.php\"><button type=\"button\">OK</button></a>";
	
?>