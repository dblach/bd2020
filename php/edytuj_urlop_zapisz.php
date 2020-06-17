<?php
	include "polaczenie.php";
	
	$idl=$_POST['idl'];
	$idu=$_POST['idu'];
	$dp=$_POST['dp'];
	$dk=$_POST['dk'];
	
	if($idu==0){
		$q=mysqli_query($l,"insert into urlopy(id_urlopu,id_lekarza,data_rozpoczecia,data_zakonczenia) values(null,$idl,\"$dp\",\"$dk\")");
	}
	else{
		$q=mysqli_query($l,"update urlopy set data_rozpoczecia=\"$dp\",data_zakonczenia=\"$dk\" where id_urlopu=$idu");
	}
	
	echo "Zmiany zostały zapisane.";
	echo "<br><a href=\"urlopy_lekarza.php?idl=$idl\"><button type=\"button\">OK</button></a>";
?>