<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title></title>
</head>

<body>
	<?php 
		include "polaczenie.php";
		$idw=$_GET['idw'];
		
		$l_in='';
		$p_in='';
		$p='';
		$gr='';
		$gz='';
		$data='';
		
		if($idw!=0){
			$q=mysqli_fetch_assoc(mysqli_query($l,"select wizyty.id_wizyty,wizyty.id_lekarza,wizyty.id_pacjenta,data,time_format(godzina_rozpoczecia,\"%H:%i\") as godzina_rozpoczecia,time_format(godzina_zakonczenia,\"%H:%i\") as godzina_zakonczenia,lekarze.imie as lekarze_imie,lekarze.nazwisko as lekarze_nazwisko,pacjenci.imie as pacjenci_imie,pacjenci.nazwisko as pacjenci_nazwisko from wizyty join lekarze on wizyty.id_lekarza=lekarze.id_lekarza join pacjenci on wizyty.id_pacjenta=pacjenci.id_pacjenta where id_wizyty=$idw"));
			$idl=$q['id_lekarza'];
			$l_in=$q['lekarze_imie'].' '.$q['lekarze_nazwisko'];
			$p_in=$q['pacjenci_imie'].' '.$q['pacjenci_nazwisko'];
			$gr=$q['godzina_rozpoczecia'];
			$gz=$q['godzina_zakonczenia'];
			$data=date_format(date_create($q['data']),'Y-m-d');	
			if($data>1000)
				$p=mysqli_fetch_array(mysqli_query($l,"select nazwa_poradni from terminy_przyjec where id_lekarza=$idl and dzien_tygodnia=weekday(\"$data\")+1 and godzina_otwarcia<=\"$gr\" and godzina_zamkniecia>=\"$gz\""))[0];
		}
	?>
	
	<h1>Edycja wizyty</h1>
	<br>
	
	<form name="wizyta">
		<table>
			<tr>
				<td>Lekarz:</td>
				<td><input type="text" disabled="true" name="lekarz" value="<?php echo $l_in;?>"></td>
				<td><a href="edytuj_wizyte_zmien_lekarza.php?idw=<?php echo $idw;?>">Zmień</a></td>
			</tr>
			<tr>
				<td>Poradnia:</td>
				<td><input type="text" disabled="true" name="poradnia" value="<?php echo $p;?>"></td>
			</tr>
			<tr>
				<td>Pacjent:</td>
				<td><input type="text" disabled="true" name="pacjent" value="<?php echo $p_in;?>"></td>
			</tr>
			<tr>
				<td>Data:</td>
				<td><input type="date" disabled="true" name="data" value="<?php echo $data;?>"></td>
				<td><a href="edytuj_wizyte_zmien_date.php?idw=<?php echo $idw;?>">Zmień</a></td>
			</tr>
			<tr>
				<td>Godzina rozpoczęcia:</td>
				<td><input type="time" disabled="true" name="godzina_rozpoczecia" value="<?php echo $gr;?>"></td>
				<td><a href="edytuj_wizyte_zmien_godzine.php?idw=<?php echo $idw;?>">Zmień</a></td>
			</tr>
			<tr>
				<td>Godzina zakończenia:</td>
				<td><input type="time" disabled="true" name="godzina_zakonczenia" value="<?php echo $gz;?>"></td>
			</tr>
		</table>
		<br>
		Działania:<br>
		<input type="submit" value="Zapisz"</input>
		<a href="usun_wizyte.php?idw=<?php echo $idw;?>"><button type="button">Usuń</a>
	</form>

</body>
</html>