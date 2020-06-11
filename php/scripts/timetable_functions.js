function add_onclick(targ){
	e=document.getElementsByClassName('time-entry');
	for(i=0;i<e.length;i++){
		e[i].setAttribute('onclick','window.location.assign("edytuj_wizyte.php?idw='+ids[i]+targ+'");');
	}
} 
