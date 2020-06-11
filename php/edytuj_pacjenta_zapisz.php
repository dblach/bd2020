<?php
	include "polaczenie.php";
	include "redirect.php";
	$idp=$_POST['idp'];
	$imie=$_POST['imie'];
	$nazwisko=$_POST['nazwisko'];
	$adres_ulica=$_POST['adres_ulica'];
	$adres_miasto=$_POST['adres_miasto'];
	$adres_kodpocztowy=$_POST['adres_kodpocztowy'];
	$pesel=$_POST['pesel'];
	$telefon=$_POST['telefon'];
	$q=mysqli_query($l,"update pacjenci set imie=\"$imie\",nazwisko=\"$nazwisko\",adres_ulica=\"$adres_ulica\",adres_miasto=\"$adres_miasto\",adres_kodpocztowy=\"$adres_kodpocztowy\",pesel=\"$pesel\",telefon=\"$telefon\" where id_pacjenta=$idp");
	redirect("wybierz_pacjenta.php?target=edytuj_pacjenta.php?");
?>