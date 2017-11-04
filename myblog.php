<?php

	session_start();

	$table="articoli";
	$query_extra=" where ((autore='webmaster' or autore='dantiii') and cartella='Blog' and classe='public') order by id desc";
	
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

	addline('<TABLE class="centered" width="100%"  valign="top">',$level);
	addline('<tr> <th class="menu">My Blog</th>',$level);
	
	printspacer(1);

	$cartella="Blog";
	$opt=string2array("cols 1000 rows 1 noextra 1"," ");   // from $from to $to 
	$campi_select="file,data,titolo,link,articolo";

    addline('<tr><td align=center valign=top>',$level);
	showdoc($table,$query_extra,$campi_select,$utente,$cartella,$actionframe,$opt);

    addline('</td></tr>',$level);
	addline('</table>',$level);
?>
