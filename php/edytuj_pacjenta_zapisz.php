<?php
	include "polaczenie.php";
	$idp=$_POST['idp'];
	$imie=$_POST['imie'];
	$nazwisko=$_POST['nazwisko'];
	$adres_ulica=$_POST['adres_ulica'];
	$adres_miasto=$_POST['adres_miasto'];
	$adres_kodpocztowy=$_POST['adres_kodpocztowy'];
	$pesel=$_POST['pesel'];
	$telefon=$_POST['telefon'];
	
	if($idp!=0){
		$q=mysqli_query($l,"update pacjenci set imie=\"$imie\",nazwisko=\"$nazwisko\",adres_ulica=\"$adres_ulica\",adres_miasto=\"$adres_miasto\",adres_kodpocztowy=\"$adres_kodpocztowy\",pesel=\"$pesel\",telefon=\"$telefon\" where id_pacjenta=$idp");
	}
	else{
		$q=mysqli_query($l,"insert into pacjenci(id_pacjenta,imie,nazwisko,adres_ulica,adres_miasto,adres_kodpocztowy,pesel,telefon) values(null,\"$imie\",\"$nazwisko\",\"$adres_ulica\",\"$adres_miasto\",\"$adres_kodpocztowy\",\"$pesel\",\"$telefon\")");
	}
	
	echo "Zmiany zostały zapisane.";
	echo "<br><a href=\"wybierz_pacjenta.php?target=edytuj_pacjenta.php?\"><button type=\"button\">OK</button></a>";
?>