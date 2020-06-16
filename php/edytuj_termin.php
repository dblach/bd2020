<!doctype html>
<html lang="pl"> 	
<head>
	<meta charset="utf-8">
	<title></title>
	<script src="scripts/search.js"></script>
</head>

<body>
	<style>
		#f select{width:100%;}
	</style>
	
	<script type="text/javascript">
		function poradnia_wyswietl_input(){
			var s=document.getElementById('poradnia');
			if(s.options[s.selectedIndex].text=='Inna...'){
				document.getElementById('poradnie_select').innerHTML="<input type=\"text\" name=\"poradnia\"/>";
				var n=document.getElementById('poradnia_r').insertCell(2);
				n.innerHTML='&nbsp;&lt;- Wpisz nazwę poradni.';
			}
		}
		
		function validate(){
			var poradnia=document.getElementById('poradnia');
			var dt=document.getElementById('dt');
			var go=Date.parse('1000-01-01 '+document.getElementById('go').value);
			var gz=Date.parse('1000-01-01 '+document.getElementById('gz').value);
			
			if(poradnia.options[poradnia.selectedIndex].text=='Wybierz...'){
				alert('Błąd: nie wybrano poradni');
			}
			else{
				if(dt.options[dt.selectedIndex].text=='Wybierz...'){
					alert('Błąd: nie wybrano dnia tygodnia.');
				}
				else{
					if(go>gz){
						alert('Błąd: ygląda na to, że godizny otwarcia i zamknięcia są zamienione miejscami.');
					}
					else{
						document.getElementById('f').submit();
					}
				}
			}
		}
	</script>
	
	<?php
		include "polaczenie.php";
		if(isset($_GET['idl'])) $idl=$_GET['idl']; else $idl=0;
		if(isset($_GET['idt'])) $idt=$_GET['idt']; else $idt=0;
		$lek=mysqli_fetch_array(mysqli_query($l,"select concat_ws(' ',nazwisko,imie) from lekarze where id_lekarza=$idl"))[0];
		if($idt!=0){
			pobierz_dane();
		}
		else{
			$dt=0;
			$por='';
			$go='00:00';
			$gz='00:00';
			$pomieszczenie='';
		}
		
		function pobierz_dane(){
			global $l;
			global $idl;
			global $idt;
			global $lek;
			global $dt;
			global $por;
			global $go;
			global $gz;
			global $pomieszczenie;
			$d=mysqli_fetch_assoc(mysqli_query($l,"select * from terminy_przyjec where id_terminu=$idt"));
			$dt=$d['dzien_tygodnia'];
			$por=$d['nazwa_poradni'];
			$go=$d['godzina_otwarcia'];
			$gz=$d['godzina_zamkniecia'];
			$pomieszczenie=$d['pomieszczenie'];
		}
		
		function pobierz_poradnie(){
			global $l;
			global $por;
			$q=mysqli_query($l,"select distinct(nazwa_poradni) from terminy_przyjec order by nazwa_poradni");
			while($p=mysqli_fetch_assoc($q)){
				$np=$p['nazwa_poradni'];
				echo "<option value=\"$np\"";
				if($np==$por) echo " selected=\"selected\"";
				echo ">$np</option>";
			}
		}
	?>
	
	<a href="index.php">Strona główna</a>
	&nbsp;&gt;&nbsp;
	Zarządzanie lekarzami
	&nbsp;&gt;&nbsp;
	<a href="wybierz_lekarza.php">Wyświetl lekarzy</a>
	&nbsp;&gt;&nbsp;
	<?php
		if($idl==0){
			echo 'Terminy przyjęć';
		}
		else{
			echo "<a href=\"terminy_lekarza.php?idl=$idl\">Terminy przyjęć</a>";
		}
	?>
	&nbsp;&gt;&nbsp;
	Edytor
	
	<hr>
	
	<form id="f" action="edytuj_termin_zapisz.php" method="post">
		<input type="hidden" name="idt" value="<?php echo $idt;?>"/>
		<input type="hidden" name="idl" value="<?php echo $idl;?>"/>
		<table>
			<tr>
				<td>Lekarz</td>
				<td><input type="text" disabled="true" name="lekarz" value="<?php echo $lek;?>"/>
			</tr>
			<tr id="poradnia_r">
				<td>Poradnia</td>
				<td>
					<div id="poradnie_select"</div>
						<select name="poradnia" id="poradnia"  onchange="poradnia_wyswietl_input();">
							<option value="0" <?php if($idt==0) echo 'selected="selected"';?>>Wybierz...</option>
							<?php pobierz_poradnie();?>
							<option value="1">Inna...</option>
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<td>Dzień tygodnia</td>
				<td>
					<select name="dt" id="dt">
						<option value="0">Wybierz...</option>
						<option value="1" <?php if($dt==1) echo 'selected="selected"';?>>Poniedziałek</option>
						<option value="2" <?php if($dt==2) echo 'selected="selected"';?>>Wtorek</option>
						<option value="3" <?php if($dt==3) echo 'selected="selected"';?>>Środa</option>
						<option value="4" <?php if($dt==4) echo 'selected="selected"';?>>Czwartek</option>
						<option value="5" <?php if($dt==5) echo 'selected="selected"';?>>Piątek</option>
						<option value="6" <?php if($dt==6) echo 'selected="selected"';?>>Sobota</option>
						<option value="7" <?php if($dt==7) echo 'selected="selected"';?>>Niedziela</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Otwarcie</td>
				<td><input type="time" name="go" id="go" value="<?php echo $go;?>"/>
			</tr>
			<tr>
				<td>Zamknięcie</td>
				<td><input type="time" name="gz" id="gz" value="<?php echo $gz;?>"/>
			</tr>
			<tr>
				<td>Pomieszczenie</td>
				<td><input type="text" name="pomieszczenie" value="<?php echo $pomieszczenie;?>"/>
			</tr>
		</table>
		<br>
		<button type="button" onclick="validate();">Zapisz</button>
		<?php
			if($idt!=0) echo "&nbsp;<a href=\"usun_termin.php?idt=$idt	&idl=$idl\"><button type=\"button\">Usuń</button></a>";
		?>
		<a href="terminy_lekarza.php?idl=<?php echo $idl;?>"><button type="button">Anuluj</button></a>
	</form>
</body>