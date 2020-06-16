function search_load(){
	tab=document.getElementsByClassName('table_search')[0];
}

function search(){
	search_load();
	term=document.getElementById('search_text').value.toLowerCase();
	
	if(term==''){
		search_clear();
	}
	else{
		for(i=1;i<tab.rows.length;i++){
			hide=true;
			for(j=0;j<tab.rows[i].cells.length;j++){
				text=tab.rows[i].cells[j].innerHTML.toLowerCase();
				if(text.includes(term)) hide=false;
			}
			if(hide) tab.rows[i].style='display:none;';
		}
	}
}

function search_clear(){
	search_load();
	document.getElementById('search_text').value='';
	for(i=1;i<tab.rows.length;i++) tab.rows[i].style='';
}