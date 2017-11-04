<?php

	$table="articoli";
	$query_extra=" where (cartella='GoodLinks' and classe='public') order by titolo asc";
	
	$cols=1;
	$rows=2;
	$direzione=$avanti.''.$indietro;	

	if($direzione!=""){
					
		if($avanti!=""){
			
			$tmp=string2array($avanti,"_");
			$from=$tmp[1];
			$to=$from+2*$cols;				
		}else{

			$tmp=string2array($indietro,"_");
			$to=$tmp[1];
			$from=$to-2*$cols;
		}
		$cartella=$tmp[0];
	}else{

		$from=0;
		$to=$from+2*$cols;
	}

	addline('<table class="centered" width="100%"  valign="top">',$level);
	addline('<tr> <th class="menu" colspan=3>I miei siti preferiti</th>',$level);
		
	printspacer(1);

	$cartella="GoodLinks";
	$opt=string2array("author 0 extra 0 cols 1000 rows 1"," ");   // from $from to $to 
	$campi_select="file,data,titolo,link,articolo,autore,extra";
    
    addline('<tr> <td width=5% /><td align=center>',$level);
	showdoc($table,$query_extra,$campi_select,$utente,$cartella,$actionframe,$opt);
    addline('</td><td width=5% /><tr/>',$level);
    addline('</table>',$level);
?>
