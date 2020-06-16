<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<?php
		$idl=$_GET['idl'];
		$idt=$_GET['idt'];
	?>

	Czy na pewno chcesz usunąć ten termin?<br>
	<a href="usun_termin_zapisz.php?idl=<?php echo $idl;?>&idt=<?php echo $idt;?>"><button type="button">Tak</button></a>
	&nbsp;
	<a href="terminy_lekarza.php?idl=<?php echo $idl;?>"><button type="button">Nie</button></a>
</body>