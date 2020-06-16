<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" href="styles/timetablejs.css">
	<link rel="stylesheet" href="styles/tabs.css">
	<script src="scripts/timetable.js"></script>
	<script src="scripts/tabs.js"></script>
</head>

<body>
	<?php
		include "polaczenie.php";
		$nowa=$_GET['nowa'];
		if($nowa=='0'){
			$idw=$_GET['idw'];
			$gr=mysqli_fetch_array(mysqli_query($l,"select time_format(godzina_rozpoczecia,\"%H:%i\") from wizyty where id_wizyty=$idw"))[0];
			$gz=mysqli_fetch_array(mysqli_query($l,"select time_format(godzina_zakonczenia,\"%H:%i\") from wizyty where id_wizyty=$idw"))[0];
		}
		else{
			$idw=0;
		}
		$idl=substr($_GET['lek'],0,strpos($_GET['lek'],','));
		$por=substr($_GET['lek'],strpos($_GET['lek'],',')+1,strlen($_GET['lek']));
		$data=substr($_GET['data'],0,strpos($_GET['data'],';'));
		$idp=$_GET['idp'];
				
		function ustaw_godziny(){
			global $l;
			global $idl;
			$go=mysqli_fetch_array(mysqli_query($l,"select time_format(min(godzina_otwarcia),\"%H\") from terminy_przyjec where id_lekarza=$idl"))[0]-1;
			$gz=23;
			return "$go,$gz";
		}
		
		function pobierz_terminy(){
			global $l;
			global $idl;
			global $data;
			global $por;

			add_events("select time_format(godzina_otwarcia,\"%H:%i\") as godzina_otwarcia,time_format(godzina_zamkniecia,\"%H:%i\") as godzina_zamkniecia,nazwa_poradni from terminy_przyjec where id_lekarza=$idl and dzien_tygodnia=weekday(\"$data\")+1 and nazwa_poradni=\"$por\"","Terminy przyjęć");
			add_events("select time_format(godzina_rozpoczecia,\"%H:%i\") as godzina_otwarcia,time_format(godzina_zakonczenia,\"%H:%i\") as godzina_zamkniecia,\"\" as nazwa_poradni from wizyty where id_lekarza=$idl and data=\"$data\"","Zaplanowane wizyty");
		}
		
		function add_events($z,$k){
			global $l;
			$q=mysqli_query($l,$z);
			while($r=mysqli_fetch_array($q)){
				$go=substr(str_replace(':',',',$r['godzina_otwarcia']),0,5);
				$gz=substr(str_replace(':',',',$r['godzina_zamkniecia']),0,5);
				$np=$r['nazwa_poradni'];
				$d="1000,01,01";
				echo "timetable.addEvent('$np','$k',new Date($d,$go),new Date($d,$gz));";
			}
		}
	?>	
	
	<script type="text/javascript">
		function dodaj_rozklad(){
			var timetable=new Timetable();
			timetable.setScope(<?php echo ustaw_godziny();?>);
			timetable.addLocations(['Terminy przyjęć','Zaplanowane wizyty']);
			<?php pobierz_terminy(); ?>
			var renderer=new Timetable.Renderer(timetable);
			renderer.draw('.timetable');
		}
		
		function validate(){
			var gr=Date.parse('1000-01-01 '+document.getElementById('gr').value);
			var gz=Date.parse('1000-01-01 '+document.getElementById('gz').value);
			if(gr>=gz){
				alert('Błąd: wygląda na to, że godizny otwarcia i zamknięcia są zamienione miejscami.');
			}
			else{
				document.getElementById('f').submit();
			}
		}
	</script>
	
	<!-- ================================================================================================================================== -->
	
	<h1>Zmiana terminu wizyty</h1>
	
	<hr>
	
	Należy wybrać godzinę mieszczącą się w terminach przyjęć lekarza i niekolidującą z innymi wizytami.<br>
	<br>
	<form action="edytuj_wizyte_zmien_godzine_zapisz.php" method="post" id="f">
		<input type="hidden" name="id_wizyty" value="<?php echo $idw;?>"/>
		<input type="hidden" name="id_lekarza" value="<?php echo $idl;?>"/>
		<input type="hidden" name="id_pacjenta" value="<?php echo $idp;?>"/>
		<input type="hidden" name="lek" value="<?php echo $_GET['lek'];?>"/>
		<input type="hidden" name="nowa" value="<?php echo $nowa;?>"/>
		<input type="hidden" name="data" value="<?php echo $data;?>"/>
		<table>
			<tr>
				<td>Wybrana data:</td>
				<td><?php echo $data;?></td>
			</tr>
			<tr>
				<td>Godzina rozpoczęcia:</td>
				<td><input type="time" name="godzina_rozpoczecia" id="gr" value="<?php echo $gr;?>"/></td>
			</tr>
			<tr>
				<td>Godzina zakończenia:</td>
				<td><input type="time" name="godzina_zakonczenia" id="gz" value="<?php echo $gz;?>"/></td>
			</tr>
		</table>
		<button onclick="validate();" type="button">Zapisz</button>
	</form>
	
	<hr>
	
	<div class="timetable"></div>
	<script> dodaj_rozklad();</script>

</body>
</html>