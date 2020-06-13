<?php
	include "polaczenie.php";
	include "redirect.php";
	$idw=$_POST['id_wizyty'];
	$idl=$_POST['id_lekarza'];
	$d=$_POST['data'];
	
	if(date_check()){
		$q=mysqli_query($l,"update wizyty set data=\"$d\" where id_wizyty=$idw");
		redirect("edytuj_wizyte.php?idw=$idw");
	}
	else{
		echo "W tym dniu lekarz nie przyjmuje!<br>";
		echo "Zmień lekarza lub wybierz inną datę.";
	}
	
	function date_check(){
		global $l;
		global $d;
		global $idl;
		$q=mysqli_query($l,"select id_terminu from terminy_przyjec where id_lekarza=$idl and dzien_tygodnia=weekday(\"$d\")+1");
		if(mysqli_num_rows($q)>0) return true; else return false;
	}
	
?>