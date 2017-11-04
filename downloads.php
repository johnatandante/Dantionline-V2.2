<?php

	$table="downloads";
	$query_extra=" where classe='public' order by categoria";
	
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

	addline('<table align = center class="centered" width="100%"  valign="top">',$level);
	addline('<tr> <th class="menu">Area Downloads</th>',$level);
	
	
	printspacer(1);

	$cartella="Downloads";
	$opt=string2array("cols 1000 rows 1 noextra 1"," ");   // from $from to $to 
	$campi_select="data,categoria,link,descrizione,autore";

	showdownloads($table,$query_extra,$campi_select,$utente,$cartella,$actionframe,$opt);
    addline('</table>',$level);
?>
