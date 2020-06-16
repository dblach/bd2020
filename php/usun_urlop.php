<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<?php
		$idl=$_GET['idl'];
		$idu=$_GET['idu'];
	?>

	Czy na pewno chcesz usunąć ten urlop?<br>
	<a href="usun_urlop_zapisz.php?idl=<?php echo $idl;?>&idu=<?php echo $idu;?>"><button type="button">Tak</button></a>
	&nbsp;
	<a href="urlopy_lekarza.php?idl=<?php echo $idl;?>"><button type="button">Nie</button></a>
</body>