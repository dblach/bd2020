<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title></title>
</head>

<body>
	<?php
		include "polaczenie.php";
		$idl=$_GET['idl'];
		$in=mysqli_fetch_array(mysqli_query($l,"select concat_ws(' ',imie,nazwisko) from lekarze where id_lekarza=$idl"))[0];
		
		function pobierz_urlopy(){
			global $l;
			global $idl;
			$q=mysqli_query($l,"select * from urlopy where id_lekarza=$idl order by data_rozpoczecia desc");
			while($r=mysqli_fetch_assoc($q)){
				echo "<tr>";
				echo "<td>".$r['data_rozpoczecia'];
				echo "<td>".$r['data_zakonczenia'];
				echo "<td><a href=\"edytuj_urlop.php?idu=".$r['id_urlopu']."&idl=$idl\"><button type=\"button\">Edytuj</button></a>";
				echo "</tr>";
			}
		}
	?>
	
	<a href="index.php">Strona główna</a>
	&nbsp;&gt;&nbsp;
	Zarządzanie lekarzami
	&nbsp;&gt;&nbsp;
	<a href="wybierz_lekarza.php">Wyświetl lekarzy</a>
	&nbsp;&gt;&nbsp;
	Urlopy
	
	<hr>
	
	<h1>Urlopy lekarza: <?php echo $in; ?></h1>
	<br>
	<a href="edytuj_urlop.php?idu=0&idl=<?php echo $idl;?>"><button type="button">Dodaj nowy</button></a>
	
	<hr>
	
	<table border="1">
		<tr>
			<th>Początek</th>
			<th>Koniec</th>
		</tr>
		<?php pobierz_urlopy();?>
	</table>
	
</body> 
