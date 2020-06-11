<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<?php
		$idl=$_GET['idl'];
	?>

	Czy na pewno chcesz usunąć lekarza?<br>
	<a href="usun_lekarza_zapisz.php?idl=<?php echo $idl;?>"><button type="button">Tak</button></a>
	&nbsp;
	<a href="edytuj_lekarza.php?idl=<?php echo $idl;?>"><button type="button">Nie</button></a>
</body>