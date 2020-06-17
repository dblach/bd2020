<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title>Strona główna</title>
</head>
<body>
	<?php
		include "polaczenie.php";
		$idl=$_GET['idl'];
		$imie='';
		$nazwisko='';
		
		if($idl!='0') pobierz_dane();
		
		/*
		function utworz_lekarza(){
			global $l;
			include "redirect.php";
			$q=mysqli_query($l,"insert into lekarze(id_lekarza,imie,nazwisko) values(null,'','')");
			$newidl=mysqli_fetch_array(mysqli_query($l,"select max(id_lekarza) from lekarze"))[0];
			redirect("edytuj_lekarza.php?idl=$newidl");
		}
		*/
		
		function pobierz_dane(){
			global $l;
			global $idl;
			global $imie;
			global $nazwisko;
			$r=mysqli_fetch_assoc(mysqli_query($l,"select * from lekarze where id_lekarza=$idl"));
			$imie=$r['imie'];
			$nazwisko=$r['nazwisko'];
		}
	?>
	
	<a href="index.php">Strona główna</a>
	&nbsp;&gt;&nbsp;
	Zarządzanie lekarzami
	&nbsp;&gt;&nbsp;
	<a href="wybierz_lekarza.php">Edytuj dane lekarzy</a>
	&nbsp;&gt;&nbsp;
	Edytor
	
	<hr>
	
	<h1>Edycja danych lekarza</h1>
	<hr>
	
	<form method="post" action="edytuj_lekarza_zapisz.php">
		<table>
			<tr>
				<td>Imię</td>
				<td><input type="text" name="imie" value="<?php echo $imie;?>"/></td>
			</tr>
			<tr>
				<td>Nazwisko</td>
				<td><input type="text" name="nazwisko" value="<?php echo $nazwisko;?>"/></td>
			</tr>
			</table>
		<input type="hidden" name="idl" value="<?php echo $idl;?>"/>
		<input type="submit" value="Zapisz"/>
		&nbsp;
		<?php if($idl!=0) echo "<a href=\"usun_lekarza.php?idl=$idl\"><button type=\"button\">Usuń</button></a>&nbsp;"; ?>
		<a href="wybierz_lekarza.php"><button type="button">Anuluj</button></a>
	</form>
</body>