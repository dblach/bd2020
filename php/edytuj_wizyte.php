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
		if(isset($_GET['target'])){
			$target=$_GET['target'];
			$target=substr($target,1,strlen($target));
		}
		else $target='';
		
		$l_in='';
		$p_in='';
		$p='';
		$gr='';
		$data='';
		$gz='';
		
		if($idw!=0){
			$q=mysqli_fetch_assoc(mysqli_query($l,"select wizyty.id_wizyty,wizyty.id_lekarza,wizyty.id_pacjenta,data,time_format(godzina_rozpoczecia,\"%H:%i\") as godzina_rozpoczecia,time_format(godzina_zakonczenia,\"%H:%i\") as godzina_zakonczenia,lekarze.imie as lekarze_imie,lekarze.nazwisko as lekarze_nazwisko,pacjenci.imie as pacjenci_imie,pacjenci.nazwisko as pacjenci_nazwisko from wizyty join lekarze on wizyty.id_lekarza=lekarze.id_lekarza join pacjenci on wizyty.id_pacjenta=pacjenci.id_pacjenta where id_wizyty=$idw"));
			$idl=$q['id_lekarza'];
			$l_in=$q['lekarze_imie'].' '.$q['lekarze_nazwisko'];
			$p_in=$q['pacjenci_imie'].' '.$q['pacjenci_nazwisko'];
			$gr=$q['godzina_rozpoczecia'];
			$gz=$q['godzina_zakonczenia'];
			$data=date_format(date_create($q['data']),'Y-m-d');	
			//if($data>1000){
				$q=mysqli_query($l,"select nazwa_poradni from terminy_przyjec where id_lekarza=$idl and dzien_tygodnia=weekday(\"$data\")+1 and godzina_otwarcia<=\"$gr\" and godzina_zamkniecia>=\"$gz\"");
				if(mysqli_num_rows($q)==0) $p='NIEPRAWIDŁOWA'; else $p=mysqli_fetch_array($q)[0];
			//}
		}
		else{
			if(isset($_GET['idl'])) $idl=$_GET['idl'];
			if(isset($_GET['data'])) $data=$_GET['data']; else $data="1000-01-01";
			if(isset($_GET['idp'])) $idp=$_GET['idp'];
			utworz_wizyte();
		}
		
		function poradnia_dodaj_informacje(){
			global $p;
			if($p=='NIEPRAWIDŁOWA'){
				echo '<td>';
				echo '-> Ustaw datę lub godzinę tak, by pokrywała się z terminem przyjęć wybranego lekarza';
				echo '</td>';
			}
		}
		
		function utworz_wizyte(){
			include "redirect.php";
			global $l;
			global $idl;
			global $idp;
			global $data;
			if(!isset($idl)) $idl=mysqli_fetch_array(mysqli_query($l,"select min(id_lekarza) from lekarze"))[0];
			if(!isset($idp)) $idp=mysqli_fetch_array(mysqli_query($l,"select min(id_pacjenta) from pacjenci"))[0];
			if(!isset($d)) $d="1001-01-01";
			//echo $idl.' '.$idp.' '.$data;
			$q=mysqli_query($l,"insert into wizyty(id_wizyty,id_lekarza,id_pacjenta,data,godzina_rozpoczecia,godzina_zakonczenia) values(null,\"$idl\",\"$idp\",\"$data\",\"00:00:00\",\"00:30:00\")");
			$idn=mysqli_fetch_array(mysqli_query($l,"select max(id_wizyty) from wizyty"))[0];
			redirect("edytuj_wizyte.php?idw=$idn");
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
				<td></td>
				<?php poradnia_dodaj_informacje();?>
			</tr>
			<tr>
				<td>Pacjent:</td>
				<td><input type="text" disabled="true" name="pacjent" value="<?php echo $p_in;?>"></td>
				<td><a href="wybierz_pacjenta.php?target=edytuj_wizyte_zmien_pacjenta_zapisz.php?idw=<?php echo $idw;?>">Zmień</a></td>
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
		<a href="usun_wizyte.php?idw=<?php echo $idw."&target='".$target."'";?>"><button type="button">Usuń</button></a>
	</form>

</body>
</html>