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
		$idw=$_GET['idw'];
		$idl=mysqli_fetch_array(mysqli_query($l,"select id_lekarza from wizyty where id_wizyty=$idw"))[0];
		$data=mysqli_fetch_array(mysqli_query($l,"select data from wizyty where id_wizyty=$idw"))[0];
		$gr=mysqli_fetch_array(mysqli_query($l,"select time_format(godzina_rozpoczecia,\"%H:%i\") from wizyty where id_wizyty=$idw"))[0];
		
		function ustaw_godziny(){
			global $l;
			global $idl;
			$go=mysqli_fetch_array(mysqli_query($l,"select time_format(min(godzina_otwarcia),\"%H\") from terminy_przyjec where id_lekarza=$idl"))[0];
			$gz=23;
			return "$go,$gz";
		}
		
		function pobierz_terminy(){
			global $l;
			global $idl;
			global $data;
			add_events("select time_format(godzina_otwarcia,\"%H:%i\") as godzina_otwarcia,time_format(godzina_zamkniecia,\"%H:%i\") as godzina_zamkniecia,nazwa_poradni from terminy_przyjec where id_lekarza=$idl and dzien_tygodnia=weekday(\"$data\")+1","Terminy przyjęć");
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
	</script>
	
	<!-- ================================================================================================================================== -->
	
	<h1>Zmiana terminu wizyty</h1>
	
	<hr>
	
	Należy wybrać godzinę mieszczącą się w terminach przyjęć lekarza i niekolidującą z innymi wizytami.<br>
	<br>
	<form action="edytuj_wizyte_zmien_godzine_zapisz.php" method="post">
		<input type="hidden" name="id_wizyty" value="<?php echo $idw;?>"/>
		<input type="time" name="godzina_rozpoczecia" value="<?php echo $gr;?>"/>
		<input type="submit" value="Zapisz"/>
	</form>
	
	<hr>
	
	<div class="timetable"></div>
	<script> dodaj_rozklad();</script>

</body>
</html>