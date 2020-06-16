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
		$idl=$_GET['idl'];
		$in=mysqli_fetch_array(mysqli_query($l,"select concat_ws(' ',imie,nazwisko) from lekarze where id_lekarza=$idl"))[0];
		
		function pobierz_terminy(){
			global $l;
			global $idl;
			$dt=['','Poniedziałek','Wtorek','Środa','Czwartek','Piątek','Sobota','Niedziela'];
			$q=mysqli_query($l,"select id_terminu,nazwa_poradni,dzien_tygodnia,time_format(godzina_otwarcia,\"%H:%i\") as godzina_otwarcia,time_format(godzina_zamkniecia,\"%H:%i\") as godzina_zamkniecia,pomieszczenie from terminy_przyjec where id_lekarza=$idl  order by dzien_tygodnia;");
			while($r=mysqli_fetch_assoc($q)){
				echo "<tr>";
				echo "<td>".$dt[$r['dzien_tygodnia']]."</td>";
				echo "<td>".$r['nazwa_poradni']."</td>";
				echo "<td>".$r['godzina_otwarcia']."</td>";
				echo "<td>".$r['godzina_zamkniecia']."</td>";
				echo "<td>".$r['pomieszczenie']."</td>";
				echo "<td><a href=\"edytuj_termin.php?idt=".$r['id_terminu']."&idl=$idl\"><button type=\"button\">Edytuj</button></a>";
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
	Terminy przyjęć
	
	<hr>
	
	<h1>Terminy przyjęć: <?php echo $in; ?></h1>
	<br>
	Wyszukaj: <input type="text" id="search_text" onchange="search();"/>
	&nbsp;
	<button type="button" onclick="search_clear();">Czyść</button>
	&nbsp;&nbsp;
	<a href="edytuj_termin.php?idt=0&idl=<?php echo $idl;?>"><button type="button">Dodaj nowy</button></a>
	
	<hr>
	
	<table border="1" class="table_search">
		<tr>
			<th>Dzień tygodnia</th>
			<th>Nazwa poradni</th>
			<th>Otwarcie</th>
			<th>Zamknięcie</th>
			<th>Pomieszczenie</th>
		</tr>
		<?php pobierz_terminy();?>
	</table>
	
</body> 
