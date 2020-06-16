<?php
	include "polaczenie.php";
	
	$nowa=$_POST['nowa'];
	if($nowa=='0') $idw=$_POST['id_wizyty'];
	$gp=$_POST['godzina_rozpoczecia'];
	//$gk=date('H:i',strtotime($gp.'+30 minutes'));
	$gk=$_POST['godzina_zakonczenia'];
	//$d=mysqli_fetch_array(mysqli_query($l,"select data from wizyty where id_wizyty=$idw"))[0];
	$d=$_POST['data'];
	//$idl=mysqli_fetch_array(mysqli_query($l,"select id_lekarza from wizyty where id_wizyty=$idw"))[0];
	$idl=$_POST['id_lekarza'];
	$idp=$_POST['id_pacjenta'];
	$data=$_POST['data'];
	$idw=$_POST['id_wizyty'];
	
	if(czy_lekarz_przyjmuje()&&czy_termin_wolny()) zapisz();
	
	function czy_lekarz_przyjmuje(){
		global $l;
		global $gp;
		global $gk;
		global $d;
		global $idl;
		$k=false;
		$tgp=strtotime($gp);
		$tgk=strtotime($gk);	
		$q=mysqli_query($l,"select godzina_otwarcia,godzina_zamkniecia from terminy_przyjec where id_lekarza=$idl and dzien_tygodnia=weekday(\"$d\")+1");
		while($r=mysqli_fetch_assoc($q)){
			$tp=$r['godzina_otwarcia'];
			$tk=$r['godzina_zamkniecia'];
			$ttp=strtotime($tp);
			$ttk=strtotime($tk);
			if($tgp>=$ttp&&$tgk<=$ttk) $k=true;
			
			//echo 'Termin: '.$tp.'-'.$tk.'<br>';
			//echo 'Godzina: '.$gp.'-'.$gk.'<br>';
			//echo $k.'<br>';
		}
		if(!$k) echo "<b>Błąd: </b>O tej godzinie lekarz nie przyjmuje.<br>";
		return $k;
	}
	
	function czy_termin_wolny(){
		global $l;
		global $gp;
		global $gk;
		global $d;
		global $idl;
		global $idw;
		$k=true;
		$q=mysqli_query($l,"select id_wizyty,godzina_rozpoczecia,godzina_zakonczenia from wizyty where id_lekarza=$idl and data=\"$d\"");
		$tgp=strtotime($gp);
		$tgk=strtotime($gk);
		while($r=mysqli_fetch_assoc($q)){
			$ti=$r['id_wizyty'];
			$wp=$r['godzina_rozpoczecia'];
			$wk=$r['godzina_zakonczenia'];
			$twp=strtotime($wp);
			$twk=strtotime($wk);
			if(($tgp<=$twp&&$tgk<=$twp)||($tgp>=$twk&&$tgk>=$twk)){
				// brak kolizji
			}
			else{
				// kolizja
				if($ti!=$idw) $k=false;
			}
		}
		if(!$k) echo "<b>Błąd: </b>ta godzina jest już zarezerwowana.<br>";
		return $k;
	}
	
	function zapisz(){
		global $l;
		global $idw;
		global $gp;
		global $gk;
		global $idl;
		global $d;
		global $idp;
		global $nowa;
		global $data;
		
		if($nowa==0){
			$q=mysqli_query($l,"update wizyty set godzina_rozpoczecia=\"$gp\",godzina_zakonczenia=\"$gk\",id_lekarza=$idl,data=\"$d\",id_pacjenta=$idp where id_wizyty=$idw");
			$t=$idw;
		}
		if($nowa==1){
			$q=mysqli_query($l,"insert into wizyty(id_wizyty,id_lekarza,id_pacjenta,data,godzina_rozpoczecia,godzina_zakonczenia) values(null,\"$idl\",\"$idp\",\"$data\",\"$gp\",\"$gk\")");
			$t=mysqli_fetch_array(mysqli_query($l,"select max(id_wizyty) from wizyty"))[0];
		}
		
		echo "Zmiany zostały zapisane.<br>";
		echo "<a href=\"edytuj_wizyte.php?idw=$t\"><button type=\"button\">OK</button></a>";
	}
?>