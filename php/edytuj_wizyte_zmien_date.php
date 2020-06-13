<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" href="styles/timetablejs.css">
	<link rel="stylesheet" href="styles/tabs.css">
	<script src="scripts/timetable.js"></script>
	<script src="scripts/tabs.js"></script>
	
</head>

<body>
	<?php
		include "polaczenie.php";
		$idw=$_GET['idw'];
		$idl=substr($_GET['lek'],0,strpos($_GET['lek'],','));
		$por=substr($_GET['lek'],strpos($_GET['lek'],',')+1,strlen($_GET['lek']));
		$idp=$_GET['idp'];
		$nowa=$_GET['nowa'];
		$dnityg=['','Pon ','Wt ','Śr ','Czw ','Pt ','So ','N '];
		//echo 'get='.print_r($_GET).'<br>';
		//echo 'idw='.$idw.'<br>';
		//echo 'idl='.$idl.'<br>';
		//echo 'por='.$por.'<br>';
		
		$r=mysqli_fetch_assoc(mysqli_query($l,"select imie,nazwisko from lekarze where id_lekarza=$idl"));
		$lek=$r['imie'].' '.$r['nazwisko'];
		if(!isset($_GET['dp'])){
			$dp=date("Y-m-d");
		}
		else{
			$dp=$_GET['dp'];
		}
		if(!isset($_GET['dk'])){
			$dk=date("Y-m-d",strtotime($dp.'+ 7 days'));
		}
		else{
			$dk=$_GET['dk'];
		}
		
		function pobierz_terminy(){
			global $l;
			global $idl;
			global $por;
			global $dnityg;
			global $dp;
			global $dk;
			
			$data=$dp;
			$nd=round((strtotime($dk)-strtotime($dp))/(60*60*24))+1;
			for($i=0;$i<$nd;$i++){
				$data=date("Y-m-d",strtotime($data.'+ 1 day'));
				$q=mysqli_query($l,"select godzina_otwarcia,godzina_zamkniecia,dzien_tygodnia from terminy_przyjec where id_lekarza=$idl and nazwa_poradni=\"$por\" and dzien_tygodnia=weekday(\"$data\")+1");
				while($r=mysqli_fetch_array($q)){
					$go=substr(str_replace(':',',',$r['godzina_otwarcia']),0,5);
					$gz=substr(str_replace(':',',',$r['godzina_zamkniecia']),0,5);
					$dt=$r['dzien_tygodnia'];
					$dd="1000,01,01";
					$data1=$dnityg[$dt].date("d.m",strtotime($data));
					echo "if(!daty.includes(\"$data1\")){";
					echo "daty.push(\"$data1\");";
					echo "timetable.addLocations(['$data1']);";
					echo "};";
					echo "timetable.addEvent('$por','$data1',new Date($dd,$go),new Date($dd,$gz));";
					echo "clicks.push('$data;$dt;$go');";
				}	
			}
		}
		
		function ustaw_godziny(){
			global $l;
			global $idl;
			$go=mysqli_fetch_array(mysqli_query($l,"select time_format(min(godzina_otwarcia),\"%H\") from terminy_przyjec where id_lekarza=$idl"))[0]-1;
			$gz=23;
			return "$go,$gz";
		}
	?>
	
	<script type="text/javascript">
		function add_timetable(){
			var timetable=new Timetable();
			var daty=new Array();
			clicks=new Array();
			timetable.setScope(<?php echo ustaw_godziny();?>);
			<?php pobierz_terminy(); ?>
			var renderer=new Timetable.Renderer(timetable);
			renderer.draw('.timetable');
			
			it=document.getElementsByClassName('time-entry');
			for(i=0;i<it.length;i++){
				it[i].setAttribute('onclick','itemclick('+i+');');
			}
		}
		
		function submit_form(){
			zaznaczone=false;
			for(i=0;i<it.length;i++){
				if(it[i].style.background!='') zaznaczone=true;
			}
			if(!zaznaczone){
				alert('Wybierz jeden z terminów');
			}
			else{
				document.getElementById('main_form').submit();
			}
		}
		
		function itemclick(i){
			for(j=0;j<it.length;j++){
				it[j].style.background='';
				it[j].style.border='1px solid #e32c1b';
			}
			it[i].style.background='green';
			it[i].style.border='1px solid green';
			document.getElementById("form_data").value=clicks[i];
		}
	</script>
	
	<!-- ======================================================================================================================================= -->
	
	<h1>Zmiana daty wizyty</h1>
	
	<hr>
	
	<form method="get" action="edytuj_wizyte_zmien_date.php">
		<input type="hidden" name="idw" value="<?php echo $idw;?>"/>
		<input type="hidden" name="lek" value="<?php echo $_GET['lek'];?>"/>
		<input type="hidden" name="nowa" value="<?php echo $nowa;?>"/>
		Wyświetl od: <input type="date" name="dp" value="<?php echo $dp;?>"/>&nbsp;
		do: <input type="date" name="dk" value="<?php echo $dk;?>"/>
		<input type="submit" value="Odśwież"/>
	</form>
	
	<hr>
	Lekarz <?php echo $lek;?> przyjmuje w poniższych godzinach:<br>
	Kliknij na wybrany termin.
	
	<div class="timetable"></div>
	<script> add_timetable();</script>
	
	<hr>
	
	<form action="edytuj_wizyte_zmien_godzine.php" method="get" id="main_form">
		<input type="hidden" name="idw" value="<?php echo $idw;?>"/>
		<input type="hidden" name="idp" value="<?php echo $idp;?>"/>
		<input type="hidden" name="lek" value="<?php echo $_GET['lek'];?>"/>
		<input type="hidden" name="data" id="form_data" value=""/>
		<input type="hidden" name="nowa" value="<?php echo $nowa;?>"/>
		<a href="edytuj_wizyte_zmien_lekarza.php?idw=<?php echo $idw;?>&nowa=<?php echo $nowa;?>&nazwa_poradni=<?php echo $_GET['nazwa_poradni'];?>&idp=<?php echo $idp;?>"><button type="button">&lt; Wstecz</button></a>
		&nbsp;
		<button type="button" onclick="submit_form();">Dalej &gt;</button>
	</form>
</body>
</html>