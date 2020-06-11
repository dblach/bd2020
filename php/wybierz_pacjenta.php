<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title></title>
	<script src="scripts/search.js"></script>
</head>
<body>
	<?php
		include "polaczenie.php";
		$target=$_GET['target'];
		
		function pobierz_pacjentow(){
			global $l;
			global $target;
			$q=mysqli_query($l,"select id_pacjenta,concat_ws(' ',nazwisko,imie) as nazwiskoimie,adres_ulica,adres_miasto,adres_kodpocztowy,telefon from pacjenci order by nazwiskoimie");
			while($r=mysqli_fetch_assoc($q)){
				echo '<tr>';
				foreach($r as $k=>$d){
					if($k=='id_pacjenta') $idp=$d;
					else echo "<td>$d</td>";
				}
				echo "<td><a href=\"$target&idp=$idp\">Wybierz</a></td>";
				echo '</tr>';
			}
		}
	?>
	
	<a href="index.php">Strona główna</a>
	&nbsp;&gt;&nbsp;
	<?php
		if($_GET['target']=='edytuj_pacjenta.php?') echo 'Zarządzanie pacjentami > Edytuj dane pacjentów';
		if($_GET['target']=='wyswietl_wizyty_pacjenta.php?') echo 'Zarządzanie pacjentami > Edytuj wizyty pacjentów';
		//if(strpos("edytuj_wizyte_zmien_pacjenta",$_GET['target'])==0) echo '<a href="edytuj_wizyte.php?idw='.$_GET['idw'].'\">Edycja wizyty</a> &gt; Wybór pacjenta';
	?>
	
	<hr>
	
	<h1>Wybór pacjenta</h1>
	<hr>
	Pacjenci w przychodni:
	&nbsp;&nbsp;&nbsp;&nbsp;
	Wyszukaj: <input type="text" id="search_text" onchange="search();"/>
	&nbsp;
	<button type="button" onclick="search_clear();">Czyść</button>
	<?php
		if($target=='edytuj_pacjenta.php?') echo "<a href=\"edytuj_pacjenta.php?&idp=0\"><button type=\"button\">Dodaj nowego</button></a>";
	?>
	<br>
	<br>
	
	<table border="1" class="table_search">
		<tr>
			<th>Nazwisko i imię</th>
			<th>Ulica</th>
			<th>Miasto</th>
			<th>Kod pocztowy</th>
			<th>Nr telefonu</th>
			<th></th>
		</tr>
		<?php pobierz_pacjentow(); ?>
	</table>
	


</body>
