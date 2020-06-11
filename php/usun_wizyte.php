<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<?php
		$idw=$_GET['idw'];
		$target=$_GET['target'];
		$target=str_replace("'","",$target);
		//echo $target;
	?>

	Czy na pewno chcesz usunąć wizytę?<br>
	<a href="usun_wizyte_zapisz.php?idw=<?php echo $idw."&target='".$target."'";?>"><button type="button">Tak</button></a>
	&nbsp;
	<a href="edytuj_wizyte.php?idw=<?php echo $idw;?>"><button type="button">Nie</button></a>
</body>