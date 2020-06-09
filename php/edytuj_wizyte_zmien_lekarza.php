<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title></title>
</head>

<body>
	<?php
		include "polaczenie.php";
		$idw=$_GET['idw'];
		$por=pobierz_poradnie();
		
		function znajdz_poradnie_lekarza($idl){
			global $l;
			$r='';
			$q=mysqli_query($l,"SELECT distinct(nazwa_poradni) from terminy_przyjec where id_lekarza=$idl order by nazwa_poradni");
			while($a=mysqli_fetch_array($q)) $r.=$a[0].', ';
			return substr($r,0,strlen($r)-2);;
		}
		
		function pobierz_lekarzy(){
			global $l;
			global $idw;
			$q=mysqli_query($l,"select * from lekarze order by nazwisko");
			while($r=mysqli_fetch_assoc($q)){
				$idl=$r['id_lekarza'];
				echo '<tr>';
				echo '<td>'.$r['nazwisko'].' '.$r['imie'].'</td>';
				echo '<td>'.znajdz_poradnie_lekarza($idl).'</td>';
				echo "<td><a href=\"edytuj_wizyte_zmien_lekarza_zapisz.php?idw=$idw&idl=$idl\">Wybierz</a></td>";
				echo '</tr>';
			}
		}
		
		function pobierz_poradnie(){
			global $l;
			global $idw;
			return mysqli_fetch_array(mysqli_query($l,"select nazwa_poradni from wizyty join terminy_przyjec on wizyty.godzina_rozpoczecia>=terminy_przyjec.godzina_otwarcia and wizyty.godzina_zakonczenia<=terminy_przyjec.godzina_zamkniecia and wizyty.id_lekarza=terminy_przyjec.id_lekarza where wizyty.id_wizyty=$idw"))[0];
		}
		
		function add_filter_checkbox(){
			global $por;
			if (strlen($por)>0) echo "<input type=\"checkbox\" id=\"filter\" onclick=\"filter();\">Wyświetl tylko lekarzy z poradni: $por</input>";
		}
	?>
	
	<script type="text/javascript">
		por="<?php echo $por;?>";
		filtered=false;
		function filter(){
			tab=document.getElementById("tab");
			for(i=1;i<tab.rows.length;i++){
				if(filtered){
					tab.rows[i].style="";
				}
				else{
					if(!tab.rows[i].cells[1].innerHTML.includes(por)) tab.rows[i].style="display:none;";
				}
			}
			filtered=!filtered;
		}
	</script>
	
	<h1>Zmiana lekarza</h1>
	<br>
	
	Wybierz z listy:&nbsp;	
	<?php add_filter_checkbox();?>
	
	<table border="1" id="tab">
		<tr>
			<th>Nazwisko i imię</th>
			<th>Poradnie</th>
			<th></th>
		</tr>
		<?php pobierz_lekarzy();?>
	</table>
	
</body>
</html>