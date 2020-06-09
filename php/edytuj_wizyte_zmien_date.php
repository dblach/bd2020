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
		$r=mysqli_fetch_assoc(mysqli_query($l,"select wizyty.id_lekarza,data,imie,nazwisko from wizyty join lekarze on wizyty.id_lekarza=lekarze.id_lekarza where id_wizyty=$idw"));
		$idl=$r['id_lekarza'];
		$data=$data=date_format(date_create($r['data']),'Y-m-d');	
		$lek=$r['imie'].' '.$r['nazwisko'];
		
		function pobierz_terminy(){
			global $l;
			global $idl;
			$dt=array("","Poniedziałek","Wtorek","Środa","Czwartek","Piątek","Sobota","Niedziela");
			$q=mysqli_query($l,"select nazwa_poradni,dzien_tygodnia,time_format(godzina_otwarcia,\"%H:%i\") as godzina_otwarcia,time_format(godzina_zamkniecia,\"%H:%i\") as godzina_zamkniecia from terminy_przyjec where id_lekarza=$idl");
			
			foreach ($dt as $a) if($a!='') echo "timetable.addLocations(['$a']);";						
			while($r=mysqli_fetch_assoc($q)){
				$np=$r['nazwa_poradni'];
				$go=substr(str_replace(':',',',$r['godzina_otwarcia']),0,5);
				$gz=substr(str_replace(':',',',$r['godzina_zamkniecia']),0,5);
				$dz=$dt[$r['dzien_tygodnia']];
				$dd="1000,01,01";
				echo "timetable.addEvent('$np','$dz',new Date($dd,$go),new Date($dd,$gz));";
			}
		}
		
		function ustaw_godziny(){
			global $l;
			global $idl;
			$go=mysqli_fetch_array(mysqli_query($l,"select time_format(min(godzina_otwarcia),\"%H\") from terminy_przyjec where id_lekarza=$idl"))[0];
			$gz=23;
			return "$go,$gz";
		}
	?>
	
	<script type="text/javascript">
		function add_timetable(){
			var timetable=new Timetable();
			timetable.setScope(<?php echo ustaw_godziny();?>);
			<?php pobierz_terminy(); ?>
			var renderer=new Timetable.Renderer(timetable);
			renderer.draw('.timetable');
		}
	</script>
	
	<!-- ======================================================================================================================================= -->
	
	<h1>Zmiana daty wizyty</h1>
	
	<hr>
	
	<form method="post" action="edytuj_wizyte_zmien_date_zapisz.php">
		<input type="hidden" name="id_wizyty" value="<?php echo $idw;?>"/>
		Data: <input type="date" name="data" value="<?php echo $data;?>"/>
	</form>
	
	<hr>
	Lekarz <?php echo $lek;?> przyjmuje:<br>
	
	<div class="timetable"></div>
	<script> add_timetable();</script>
</body>
</html>