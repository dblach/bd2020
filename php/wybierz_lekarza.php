<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title></title>
	<script src="scripts/search.js"></script>
</head>

<body>
	<?php include "polaczenie.php"; ?>
	
	<a href="index.php">Strona główna</a>
	&nbsp;&gt;&nbsp;
	Zarządzanie lekarzami
	&nbsp;&gt;&nbsp;
	Wyświetl lekarzy
	
	<hr>
	
	<h1>Wybór lekarza</h1>
	<br>
	
	Wyszukaj: <input type="text" id="search_text" onchange="search();"/>
	&nbsp;
	<button type="button" onclick="search_clear();">Czyść</button>
	<a href="edytuj_lekarza.php?idl=0"><button type="button">Dodaj nowego</button></a>
	<br>
	<br>
	
	<table border="1" class="table_search">
	<?php
		$q=mysqli_query($l,"select * from lekarze;");
		while($r=mysqli_fetch_assoc($q)){
			echo "<tr>";
			echo "<td>".$r['imie']." ".$r['nazwisko']."</td>";
			echo '<td><a href="wizyty_lekarza.php?idl='.$r['id_lekarza'].'">Wizyty</a></td>';
			echo '<td><a href="terminy_lekarza.php?idl='.$r['id_lekarza'].'">Terminy przyjęć</td>';
			echo '<td><a href="edytuj_lekarza.php?idl='.$r['id_lekarza'].'">Edytuj dane</td>';
			echo "</tr>";
		}
	?>
	</table>

</body>
</html>