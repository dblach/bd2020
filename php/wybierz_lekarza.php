<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title></title>
</head>

<body>
	<?php include "polaczenie.php"; ?>
	
	<h1>Wybór lekarza</h1>
	<br>
	
	<table border="1">
	<?php
		$q=mysqli_query($l,"select * from lekarze;");
		while($r=mysqli_fetch_assoc($q)){
			echo "<tr>";
			echo "<td>".$r['imie']." ".$r['nazwisko']."</td>";
			echo '<td><a href="wizyty_lekarza.php?idl='.$r['id_lekarza'].'"><button type="button">Wizyty</button></a>';
			echo "</tr>";
		}
	?>
	</table>

</body>
</html>