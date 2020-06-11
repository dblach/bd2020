<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<?php
		$idp=$_GET['idp'];
	?>

	Czy na pewno chcesz usunąć pacjenta?<br>
	<a href="usun_pacjenta_zapisz.php?idp=<?php echo $idp;?>"><button type="button">Tak</button></a>
	&nbsp;
	<a href="edytuj_pacjenta.php?idp=<?php echo $idp;?>"><button type="button">Nie</button></a>
</body>