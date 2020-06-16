<?php
	include "polaczenie.php";
	
	$idt=$_POST['idt'];
	$idl=$_POST['idl'];
	$poradnia=$_POST['poradnia'];
	$dt=$_POST['dt'];
	$go=$_POST['go'];
	$gz=$_POST['gz'];
	$pomieszczenie=$_POST['pomieszczenie'];
	
	if($idt==0){
		$q=mysqli_query($l,"insert into terminy_przyjec(id_terminu,id_lekarza,nazwa_poradni,dzien_tygodnia,godzina_otwarcia,godzina_zamkniecia,pomieszczenie) values('',$idl,\"$poradnia\",$dt,\"$go\",\"$gz\",\"$pomieszczenie\")");
	}
	else{
		$q=mysqli_query($l,"update terminy_przyjec set nazwa_poradni=\"$poradnia\",dzien_tygodnia=$dt,godzina_otwarcia=\"$go\",godzina_zamkniecia=\"$gz\",pomieszczenie=\"$pomieszczenie\" where id_terminu=$idt");
	}
	
	echo "Zmiany zostały zapisane.";
	echo "<br><a href=\"terminy_lekarza.php?idl=$idl\"><button type=\"button\">OK</button></a>";
?>