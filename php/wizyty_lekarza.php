<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" href="styles/timetablejs.css">
</head>

<body>
	<?php
		include "polaczenie.php";
		
		$idl=$_GET['idl'];
		if(!isset($_GET['d'])) $d=date('Y-m-d'); else $d=$_GET['d'];
		$n=mysqli_fetch_assoc(mysqli_query($l,"select imie,nazwisko from lekarze where id_lekarza=$idl"));
	?>
	
	
	<h1>Kalendarz wizyt lekarza: <?php echo $n['imie'].' '.$n['nazwisko'] ?></h1>
	<br>
	
	<hr>
	<h3>
		<form action="wizyty_lekarza.php" method="get">
			Data: <input type="text" name="d" value="<?php echo $d;?>">
			<input type="hidden" name="idl" value="<?php echo $idl;?>">
			<input type="submit" value="Zmień">
		</form>
	</h3>
	
	<hr>
	
	<table border="1">
	<tr>
		<th>data</th>
		<th>czas</th>
		<th>pacjent</th>
	</tr>
	<?php
		$q=mysqli_query($l,"SELECT id_wizyty,wizyty.id_pacjenta,data,godzina_rozpoczecia,godzina_zakonczenia,imie,nazwisko FROM wizyty join pacjenci on wizyty.id_pacjenta=pacjenci.id_pacjenta where id_lekarza=$idl and data=\"$d\" order by godzina_rozpoczecia");
		while($r=mysqli_fetch_assoc($q)){
			echo '<tr>';
			echo '<td>'.$r['data'].'</td>';
			echo '<td>'.$r['godzina_rozpoczecia'].' - '.$r['godzina_zakonczenia'].'</td>';
			echo '<td>'.$r['nazwisko'].' '.$r['imie'].'</td>';
			echo '</tr>';
		}
		
	?>
	</table>
	
	<div class="timetable"></div>
	<script src="scripts/timetable.js"></script>
	<script>
		var timetable = new Timetable();
		timetable.addLocations(['']);
		timetable.setScope(9,3);
		<?php
			$q=mysqli_query($l,"SELECT id_wizyty,wizyty.id_pacjenta,data,godzina_rozpoczecia,godzina_zakonczenia,imie,nazwisko FROM wizyty join pacjenci on wizyty.id_pacjenta=pacjenci.id_pacjenta where id_lekarza=$idl and data=\"$d\" order by godzina_rozpoczecia");
			while($r=mysqli_fetch_assoc($q)){
				$dd=str_replace('-',',',$r['data']);
				$gr=substr(str_replace(':',',',$r['godzina_rozpoczecia']),0,5);
				$gz=substr(str_replace(':',',',$r['godzina_zakonczenia']),0,5);
				$nn=$r['nazwisko'];
				$ni=$r['imie'];
				echo "timetable.addEvent('$nn $ni','',new Date($dd,$gr),new Date($dd,$gz));\n";
			}
		?>
		var renderer = new Timetable.Renderer(timetable);
		renderer.draw('.timetable');
	</script>

</body>
</html>