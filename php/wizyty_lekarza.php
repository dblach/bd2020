<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" href="styles/timetablejs.css">
	<link rel="stylesheet" href="styles/tabs.css">
	<script src="scripts/timetable.js"></script>
	<script src="scripts/tabs.js"></script>
	<script src="scripts/timetable_functions.js"></script>
</head>

<body>
	<?php
		include "polaczenie.php";
		
		$idl=$_GET['idl'];
		if(!isset($_GET['d'])) $d=date('Y-m-d'); else $d=$_GET['d'];
		$n=mysqli_fetch_assoc(mysqli_query($l,"select imie,nazwisko from lekarze where id_lekarza=$idl"));
		
		// ================================================================================================
		
		$zap="select wizyty.id_wizyty,wizyty.id_pacjenta,data,time_format(godzina_rozpoczecia,\"%H:%i\") as godzina_rozpoczecia,time_format(godzina_zakonczenia,\"%H:%i\") as godzina_zakonczenia,imie,nazwisko,nazwa_poradni
		from wizyty
		join pacjenci on wizyty.id_pacjenta=pacjenci.id_pacjenta
		join terminy_przyjec on wizyty.id_lekarza=terminy_przyjec.id_lekarza and wizyty.godzina_rozpoczecia>=terminy_przyjec.godzina_otwarcia and wizyty.godzina_zakonczenia<=terminy_przyjec.godzina_zamkniecia and terminy_przyjec.dzien_tygodnia=weekday(wizyty.data)+1
		where wizyty.id_lekarza=$idl and data=\"$d\"";
		
		$q=mysqli_fetch_assoc(mysqli_query($l,"select time_format(min(godzina_otwarcia),\"%H\") as godzina_otwarcia,time_format(max(godzina_zamkniecia),\"%H\") as godzina_zamkniecia from terminy_przyjec where id_lekarza=$idl and dzien_tygodnia=weekday(\"$d\")+1"));
			
		// ================================================================================================
			
		$go=$q['godzina_otwarcia'];
		//$gz=$q['godzina_zamkniecia']+1;
		$gz=23; //problem z wyświetlaniem
		
		// ================================================================================================
		
		function add_appointments(){
			global $l;
			global $zap;
			$q=mysqli_query($l,$zap);
			while($r=mysqli_fetch_assoc($q)){
				$dd=str_replace('-',',',$r['data']);
				$gr=substr(str_replace(':',',',$r['godzina_rozpoczecia']),0,5);
				$gz=substr(str_replace(':',',',$r['godzina_zakonczenia']),0,5);
				$nn=$r['nazwisko'];
				$ni=$r['imie'];
				$np=$r['nazwa_poradni'];
				$idw=$r['id_wizyty'];
				echo "if(!loc.includes(\"$np\")){";
				echo "loc.push(\"$np\");";
				echo "timetable.addLocations(['$np']);";
				echo "}";
				echo "timetable.addEvent('$nn $ni','$np',new Date($dd,$gr),new Date($dd,$gz));\n";
				echo "ids.push(\"$idw\");";
			}			
		}
	?>
	
	
	<h1>Kalendarz wizyt lekarza: <?php echo $n['imie'].' '.$n['nazwisko'] ?></h1>
	<br>
	
	<hr>
	
	<h3>
		<form action="wizyty_lekarza.php" method="get">
			Data: <input type="date" name="d" value="<?php echo $d;?>">
			<input type="hidden" name="idl" value="<?php echo $idl;?>">
			<input type="submit" value="Zmień">
		</form>
	</h3>
	
	<hr>
	
	<div class="tab">
		<button class="tablinks" onclick="changeTab(event,'Widokdnia')" id="defaultOpen">Widok dnia</button>
		<button class="tablinks" onclick="changeTab(event,'Lista')">Lista</button>
	</div>
	
	<div id="Lista" class="tabcontent">
		<table border="1">
		<tr>
			<th>data</th>
			<th>czas</th>
			<th>pacjent</th>
			<th>poradnia</th>
			<th></th>
		</tr>
		<?php
			$q=mysqli_query($l,$zap);
			while($r=mysqli_fetch_assoc($q)){
				echo '<tr>';
				echo '<td>'.$r['data'].'</td>';
				echo '<td>'.$r['godzina_rozpoczecia'].' - '.$r['godzina_zakonczenia'].'</td>';
				echo '<td>'.$r['nazwisko'].' '.$r['imie'].'</td>';
				echo '<td>'.$r['nazwa_poradni'].'</td>';
				echo '<td><a href="edytuj_wizyte.php?idw='.$r['id_wizyty'].'">Edytuj</a></td>';
				echo '</tr>';
			}
		?>
		</table>
	</div>
	
	<div id="Widokdnia" class="tabcontent">
		<div class="timetable"></div>
		<script>
			var timetable=new Timetable();
			var loc=[];
			var ids=[];
			timetable.setScope(<?php echo "$go,$gz";?>);
			<?php add_appointments(); ?>
			var renderer=new Timetable.Renderer(timetable);
			renderer.draw('.timetable');
			add_onclick();
		</script>
	</div>

	<script>
		document.getElementById("defaultOpen").click();
	</script>
</body>
</html>