<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title></title>
</head>

<body>
	<h1>1. Wybór poradni</h1>
	Wyświetlone są poradnie, do których przypisany jest co najmniej 1 przyjmujący lekarz.<br>
	<br>
	
	<table border="1">
	<?php
		$q=mysqli_query($l,"select distinct(nazwa_poradni) from terminy_przyjec order by nazwa_poradni;");
		while($r=mysqli_fetch_assoc($q){
			//echo "<tr><td><a href="
	?>
	</table>

</body>
</html>