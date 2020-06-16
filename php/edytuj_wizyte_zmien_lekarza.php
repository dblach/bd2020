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
		$nowa=$_GET['nowa'];
		
		if($nowa=='0'){
			$idlw=mysqli_fetch_array(mysqli_query($l,"select id_lekarza from wizyty where id_wizyty=$idw;"))[0];
			$idp=mysqli_fetch_array(mysqli_query($l,"select id_pacjenta from wizyty where id_wizyty=$idw;"))[0];
		}
		else{
			$porw=0;
			$idp=$_GET['idp'];
		}
		
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
			global $idlw;
			if(isset($_GET['nazwa_poradni'])) $porw=$_GET['nazwa_poradni']; else $porw=$_GET['idl'];
			$q=mysqli_query($l,"select * from lekarze order by nazwisko");
			while($r=mysqli_fetch_assoc($q)){
				$idl=$r['id_lekarza'];
				$por=mysqli_query($l,"select distinct(nazwa_poradni) from terminy_przyjec where id_lekarza=$idl");
				while($rp=mysqli_fetch_assoc($por)){
					echo '<tr>';
					echo '<td>'.$r['nazwisko'].' '.$r['imie'].'</td>';
					$nazwapor=$rp['nazwa_poradni'];
					echo "<td>$nazwapor</td>";	
					$v=$idl.','.$rp['nazwa_poradni'];
					echo '<td><input type="radio" name="lek" value="'.$v.'" ';
					if("$idlw,$porw"==$v) echo 'checked="true"';
					echo '/></td>';
					echo '</tr>';
				}
			}
		}
		
		function pobierz_poradnie(){
			//global $l;
			//global $idw;
			//return mysqli_fetch_array(mysqli_query($l,"select nazwa_poradni from wizyty join terminy_przyjec on wizyty.godzina_rozpoczecia>=terminy_przyjec.godzina_otwarcia and wizyty.godzina_zakonczenia<=terminy_przyjec.godzina_zamkniecia and wizyty.id_lekarza=terminy_przyjec.id_lekarza where wizyty.id_wizyty=$idw"))[0];
			if(isset($_GET['nazwa_poradni'])) return $_GET['nazwa_poradni'];
			else return '';
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

	<form action="edytuj_wizyte_zmien_date.php" method="get">
		<input type="hidden" name="idw" value="<?php echo $idw;?>"/>
		<input type="hidden" name="nowa" value="<?php echo $nowa;?>"/>
		<input type="hidden" name="idp" value="<?php echo $idp;?>"/>
		<input type="hidden" name="nazwa_poradni" value="<?php echo $_GET['nazwa_poradni'];?>"/>
		<?php if(isset($_GET['dp'])) echo "<input type=\"hidden\" name=\"dp\" value=\"".$_GET['dp']."\"/>";?>
		<table border="1" id="tab">
			<tr>
				<th>Nazwisko i imię</th>
				<th>Poradnia</th>
				<th></th>
			</tr>
			<?php pobierz_lekarzy();?>
		</table>
	
	
		<hr>
	
		<a href="edytuj_wizyte.php?idw=<?php echo $idw;?>"><button type="button">&lt; Wstecz</button></a>
		&nbsp;
		<input type="submit" value="Dalej &gt;"/>
	
	</form>
</body>
</html>