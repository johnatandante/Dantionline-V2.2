<?php

	session_start();	

	$max_rows=-1;
	$table="news";
	$n_campi=2;
	$query_extra="order by id desc";
	$colspan=$n_campi;
	$n_rows="20";
	$direzione=$avanti.''.$indietro;

	$level = 0;

	addline('<TABLE class="centered" width="100%"  valign="top">',$level);
	addline('<tr>',++$level);

	
	addline('<th class="menu" colspan='.$colspan.'>',$level);
	addline('Le News Del Sito',$level);
	addline('</th>',$level);
	printspacer(1);
	addline('<tr ><td>',$level);
	addline('<TABLE width="100%" align="center" class="left" valign="top">',++$level);
	
	addline('<tr><td><table class="centered" width="95%" align="center">',++$level);
	$campi_select=string2array("id data messaggio nome"," ");
	$campi_show=string2array("data messaggio"," ");
	$b_show=string2array(""," ");
	
	if($direzione!=""){
		
		if($avanti!=""){
		
			$from=$avanti;
			$to=$from+$n_rows;
		}else{
			
			$to=$indietro;
			$from=$to-$n_rows;
		}

	}else{

		$from=$avanti;
		$to=$from+$n_rows;
	}

	// opzioni speciali
	$opt=string2array("messagelength 0 from ".$from." to ".$to." AddedBy"," ");
	$actionframe="index.php?page=news";

	show4edit($table,$query_extra,$campi_select,$campi_show,$utente,$actionframe,$b_show,$opt);		
	
	addline('</table></td>',--$level);
	addline('</table></td></table>',--$level);
	
?>