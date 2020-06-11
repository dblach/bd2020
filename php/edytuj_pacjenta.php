<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title>Strona główna</title>
</head>
<body>
	<?php
		include "polaczenie.php";
		$idp=$_GET['idp'];
		$imie='';
		$nazwisko='';
		$adres_ulica='';
		$adres_miasto='';
		$adres_kodpocztowy='';
		$pesel='';
		$telefon='';
		
		if($idp=='0'){
			utworz_pacjenta();
		}
		else{
			pobierz_dane();
		}
		
		function utworz_pacjenta(){
			global $l;
			include "redirect.php";
			$q=mysqli_query($l,"insert into pacjenci(id_pacjenta,imie,nazwisko,adres_ulica,adres_miasto,adres_kodpocztowy,pesel,telefon) values(null,'','',null,null,null,null,'')");
			$newidp=mysqli_fetch_array(mysqli_query($l,"select max(id_pacjenta) from pacjenci"))[0];
			redirect("edytuj_pacjenta.php?idp=$newidp");
		}
		
		function pobierz_dane(){
			global $l;
			global $idp;
			global $imie;
			global $nazwisko;
			global $adres_ulica;
			global $adres_miasto;
			global $adres_kodpocztowy;
			global $pesel;
			global $telefon;
			$r=mysqli_fetch_assoc(mysqli_query($l,"select * from pacjenci where id_pacjenta=$idp"));
			$imie=$r['imie'];
			$nazwisko=$r['nazwisko'];
			$adres_ulica=$r['adres_ulica'];
			$adres_miasto=$r['adres_miasto'];
			$adres_kodpocztowy=$r['adres_kodpocztowy'];
			$pesel=$r['pesel'];
			$telefon=$r['telefon'];
		}
	?>
	
	<a href="index.php">Strona główna</a>
	&nbsp;&gt;&nbsp;
	Zarządzanie pacjentami
	&nbsp;&gt;&nbsp;
	<a href="wybierz_pacjenta.php?target=edytuj_pacjenta.php?">Edytuj dane pacjentów</a>
	&nbsp;&gt;&nbsp;
	Edytor
	
	<hr>
	
	<h1>Edycja danych pacjenta</h1>
	<hr>
	
	<form method="post" action="edytuj_pacjenta_zapisz.php">
		<table>
			<tr>
				<td>Imię</td>
				<td><input type="text" name="imie" value="<?php echo $imie;?>"/></td>
			</tr>
			<tr>
				<td>Nazwisko</td>
				<td><input type="text" name="nazwisko" value="<?php echo $nazwisko;?>"/></td>
			</tr>
			<tr>
				<td>Adres - ulica</td>
				<td><input type="text" name="adres_ulica" value="<?php echo $adres_ulica;?>"/></td>
			</tr>
			<tr>
				<td>Adres - miasto</td>
				<td><input type="text" name="adres_miasto" value="<?php echo $adres_miasto;?>"/></td>
			</tr>
			<tr>
				<td>Adres - kod pocztowy</td>
				<td><input type="text" name="adres_kodpocztowy" value="<?php echo $adres_kodpocztowy;?>"/></td>
			</tr>
			<tr>
				<td>Nr PESEL</td>
				<td><input type="text" name="pesel" value="<?php echo $pesel;?>"/></td>
			</tr>
			<tr>
				<td>Nr telefonu</td>
				<td><input type="text" name="telefon" value="<?php echo $telefon;?>"/></td>
			</tr>
		</table>
		<input type="hidden" name="idp" value="<?php echo $idp;?>"/>
		<input type="submit" value="Zapisz"/>
		&nbsp;
		<a href="usun_pacjenta.php?idp=<?php echo $idp;?>"><button type="button">Usuń</button></a>
		&nbsp;
		<a href="wybierz_pacjenta.php?target=edytuj_pacjenta.php?"><button type="button">Anuluj</button></a>
	</form>
</body>