<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" href="styles/timetablejs.css">
	<link rel="stylesheet" href="styles/tabs.css">
	<script src="scripts/timetable.js"></script>
	<script src="scripts/timetable_functions.js"></script>
	<script src="scripts/tabs.js"></script>
</head>
<body>
	<style>
		.timetable ul.room-timeline li{height:101px !important;}
		.time-entry{height:100px !important;}
		.timetable aside li{height:100px !important;}
		small{height:100%;}
	</style>

	<?php
		include "polaczenie.php";
		$idp=$_GET['idp'];
		if(!isset($_POST['dp'])){
			$dp=date('Y-m-d');
		}
		else{
			$dp=$_POST['dp'];
		}
		$dk=date('Y-m-d',strtotime($dp.'+ 7 days'));
		$pacjent_imienazwisko=mysqli_fetch_array(mysqli_query($l,"select concat_ws(' ',imie,nazwisko) from pacjenci where id_pacjenta=$idp"))[0];
		$gp=mysqli_fetch_array(mysqli_query($l,"select time_format(min(godzina_rozpoczecia),\"%H\") from wizyty where id_pacjenta=$idp and data>=\"$dp\" and data<=\"$dk\""))[0]-1;
		$gk=23;
		$dt=['','Pon ','Wt ','Śr ','Czw ','Pt ','So ','N '];
		$z="select id_wizyty,wizyty.id_lekarza,data,time_format(godzina_rozpoczecia,\"%H:%i\") as godzina_rozpoczecia,time_format(godzina_zakonczenia,\"%H:%i\") as godzina_zakonczenia,concat_ws(' ',nazwisko,imie) as lekarz,weekday(data)+1 as dt,date_format(data,\"%e.%m\") as da from wizyty join lekarze on lekarze.id_lekarza=wizyty.id_lekarza where id_pacjenta=$idp and data>=\"$dp\" and data<=\"$dk\" order by data";
		
		function pobierz_wizyty_widokdnia(){
			global $l;
			global $z;
			global $dt;
			$q=mysqli_query($l,$z);
			while($r=mysqli_fetch_assoc($q)){
				$dd=str_replace('-',',',$r['data']);
				$dl=$dt[$r['dt']].$r['da'];
				$gr=substr(str_replace(':',',',$r['godzina_rozpoczecia']),0,5);
				$gz=substr(str_replace(':',',',$r['godzina_zakonczenia']),0,5);
				$lek=$r['lekarz'];
				$idw=$r['id_wizyty'];
				$n="<font size=\"1px\">".$r['godzina_rozpoczecia']."<br>-".$r['godzina_zakonczenia']."</font><br>$lek";
				echo "t.push('$n');";
				echo "hov.push('".$r['godzina_rozpoczecia']."-".$r['godzina_zakonczenia']." $lek');";
				echo "if(!loc.includes(\"$dl\")){";
				echo "loc.push(\"$dl\");";
				echo "timetable.addLocations(['$dl']);";
				echo "}";
				echo "timetable.addEvent('$lek','$dl',new Date($dd,$gr),new Date($dd,$gz));";
				echo "ids.push(\"$idw\");";
			}
		}
		
		function pobierz_wizyty_lista(){
			global $l;
			global $z;
			global $dt;
			global $idp;
			global $dp;
			$q=mysqli_query($l,$z);
			
			while($r=mysqli_fetch_assoc($q)){
				$gr=$r['godzina_rozpoczecia'];
				$gz=$r['godzina_zakonczenia'];
				$idl=$r['id_lekarza'];
				$idw=$r['id_wizyty'];
				$data=$r['data'];
				$pq=mysqli_query($l,"select nazwa_poradni from terminy_przyjec where id_lekarza=$idl and dzien_tygodnia=weekday(\"$data\")+1 and godzina_otwarcia<=\"$gr\" and godzina_zamkniecia>=\"$gz\"");
				if(mysqli_num_rows($pq)==0) $p='?'; else $p=mysqli_fetch_array($pq)[0];
				
				echo "<tr>";
				echo "<td>".$dt[$r['dt']].$r['da']."</td>";
				echo "<td>$gr - $gz</td>";
				echo "<td>".$r['lekarz']."</td>";
				echo "<td>$p</td>";
				echo '<td><a href="edytuj_wizyte.php?idw='.$r['id_wizyty']."&target=wyswietl_wizyty_pacjenta.php?idp=$idp&dp=$dp\">Edytuj</a></td>";
				echo "</tr>";
			}
		}
	?>

	<a href="index.php">Strona główna</a>
	&nbsp;&gt;&nbsp;
	Zarządzanie pacjentami
	&nbsp;&gt;&nbsp;
	<a href="wybierz_pacjenta.php?target=wyswietl_wizyty_pacjenta.php?">Edytuj wizyty pacjentów</a>
	&nbsp;&gt;&nbsp;
	Wizyty pacjenta
	
	<hr>
	
	<h2>Wizyty pacjenta: <?php echo $pacjent_imienazwisko;?></h2>
	<br>
	<form action="wyswietl_wizyty_pacjenta.php?&idp=<?php echo $idp;?>" method="post">
		Okres: od <input type="date" name="dp" value="<?php echo $dp;?>"/>
		&nbsp;
		do: <input type="date" name="dk" disabled="true" value="<?php echo $dk;?>"/>
		&nbsp;
		<input type="submit" value="Zmień"/>
		&nbsp;
		<a href="edytuj_wizyte_zmien_lekarza.php?idp=<?php echo $idp;?>&idw=0&nowa=1&nazwa_poradni="><button type="button">Dodaj nową</button></a>
	</form>

	<hr>
	
	<div class="tab">
		<button class="tablinks" onclick="changeTab(event,'Widoktygodnia')" id="defaultOpen">Widok tygodnia</button>
		<button class="tablinks" onclick="changeTab(event,'Lista')">Lista</button>
	</div>
	
	<div id="Widoktygodnia" class="tabcontent">
		<div class="timetable"></div>
		<script>
			t=new Array();
			hov=new Array();
			var timetable=new Timetable();
			var loc=[];
			var ids=[];
			timetable.setScope(<?php echo "$gp,$gk";?>);
			<?php pobierz_wizyty_widokdnia(); ?>
			var renderer=new Timetable.Renderer(timetable);
			renderer.draw('.timetable');
			add_onclick("&target='wyswietl_wizyty_pacjenta.php?dp=<?php echo $dp;?>&idp=<?php echo $idp;?>'");
			e=document.getElementsByTagName('small');
			f=document.getElementsByClassName('room-timeline')[0].getElementsByTagName('span');
			for(i=0;i<t.length;i++){
				e[i].innerHTML=t[i];
				f[i].setAttribute('title',hov[i]);
			}
		</script>
	</div>
	
	<div id="Lista" class="tabcontent">
		<table border="1">
		<tr>
			<th>Data</th>
			<th>Godziny</th>
			<th>Lekarz</th>
			<th>Poradnia</th>
		</tr>
		<?php pobierz_wizyty_lista();?>
		</table>
	</div>
	
	<script>
		document.getElementById("defaultOpen").click();
	</script>
</body>