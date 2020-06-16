<!doctype html>
<html lang="pl"> 	
<head>
	<meta charset="utf-8">
	<title></title>
</head>

<body>
	<?php
		include "polaczenie.php";
		if(isset($_GET['idl'])) $idl=$_GET['idl']; else $idl=0;
		if(isset($_GET['idu'])) $idu=$_GET['idu']; else $idu=0;
		$lek=mysqli_fetch_array(mysqli_query($l,"select concat_ws(' ',nazwisko,imie) from lekarze where id_lekarza=$idl"))[0];
		if($idu!=0){
			pobierz_dane();
		}
		else{
			$dp=date('Y-m-d');
			$dk=date('Y-m-d',strtotime($dp.' + 14 days'));
		}
		
		function pobierz_dane(){
			global $l;
			global $idl;
			global $idu;
			global $dp;
			global $dk;
			$d=mysqli_fetch_assoc(mysqli_query($l,"select * from urlopy where id_urlopu=$idu"));
			$dp=$d['data_rozpoczecia'];
			$dk=$d['data_zakonczenia'];
		}
	?>
	
	<a href="index.php">Strona główna</a>
	&nbsp;&gt;&nbsp;
	Zarządzanie lekarzami
	&nbsp;&gt;&nbsp;
	<a href="wybierz_lekarza.php">Wyświetl lekarzy</a>
	&nbsp;&gt;&nbsp;
	<?php
		if($idu==0){
			echo 'Urlopy';
		}
		else{
			echo "<a href=\"urlopy_lekarza.php?idl=$idl\">Urlopy</a>";
		}
	?>
	&nbsp;&gt;&nbsp;
	Edytor
	
	<hr>
	
	<form action="edytuj_urlop_zapisz.php" method="post">
		<input type="hidden" name="idu" value="<?php echo $idu;?>"/>
		<input type="hidden" name="idl" value="<?php echo $idl;?>"/>
		<table>
			<tr>
				<td>Lekarz</td>
				<td><input type="text" disabled="true" name="lekarz" value="<?php echo $lek;?>"/>
			<tr>
				<td>Początek</td>
				<td><input type="date" name="dp" value="<?php echo $dp;?>"/>
			</tr>
			<tr>
				<td>Koniec</td>
				<td><input type="date" name="dk" value="<?php echo $dk;?>"/>
			</tr>
		</table>
		<br>
		<input type="submit" value="Zapisz"/>
		<?php
			if($idu!=0) echo "&nbsp;<a href=\"usun_urlop.php?idu=$idu&idl=$idl\"><button type=\"button\">Usuń</button></a>";
		?>
		<a href="urlopy_lekarza.php?idl=<?php echo $idl;?>"><button type="button">Anuluj</button></a>
	</form>
</body>