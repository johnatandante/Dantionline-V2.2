<?php
	session_start();
	
	$level = 0;
	$table="utenti";
	$id_alias="nome";
	$query_extra=" order by ".$id_alias." asc";
		
	// actionframe
	$actionframe="index.php?page=utenti";	
	$target="default";
		
	// opzioni speciali
	$n_rows="10";
	$direzione=$avanti.''.$indietro;

	if($invia=="invia"){
		$stringa=find_nextIndex(get_radiceid("mail"))."+".estrai_data()."+".$utente."+".$nome."+".$sms."+sì";
		$values=string2array($stringa,"+");
		add_record("mail",$values);
	}


	addline('<TABLE class="centered" width="100%"  valign="top">',$level);
	addline('<tr> <th class="menu">Utenti del Sito</th>',$level);

	printspacer(1);

	addline('<tr><td><table class="centered" width="95%"  valign="top" align="center">',$level);
	
	$direzione=$avanti."".$indietro;
	if($direzione!=""){
		
		if($avanti!=""){
		
			$from=$avanti;
			$to=$from+$n_rows;
		}else{
			
			$to=$indietro;
			$from=$to-$n_rows;
		}

	}else{

		$from=$inizio;
		$to=$from+$n_rows;
	}		
	
	$nome_campi=string2array("nome descrizione classe mail sitoweb password foto nome commento last_login"," ");

	if($mostra=="mostra"){
	
		$button_show=string2array("InviaMessaggio"," ");
		$hide=string2array("nome descrizione classe password foto"," ");
		$actionframe=$actionframe.'&inizio='.$from;
		$target="default";
		
		addline('<tr><th class="menu_2" colspan=2><a class="menulink" href="'.$actionframe.'">Utente '.$nome.'</a></th>',$level);
		printspacer(1);

		// la variabile di nome "$nome" è la variabile che tiene il valore del campo "nome" della
		// tabella guestbook passata dalla funzione show4edit
		showrow($table,$nome,$nome_campi,$hide,$utente,$button_show,$actionframe,$target);

		printspacer(1);
		addline('<tr><th class="menu_2" colspan=2><a class="menulink" href="'.$actionframe.'">Ritorna</a></th>',$level);

	}else{

		// opzioni speciali
		$opt=string2array("messagelength 30 from ".$from." to ".$to." id_alias ".$id_alias." id_index ".$id_index." 1"," ");

		// bottoni da visualizzare
		$button_show=string2array("mostra"," ");

		// campi su cui fare la select campi da visualizzare
		$campi_show=string2array("foto nome commento last_login"," ");		
		
		addline('<tr><th class="menu_2" colspan='.(sizeof($button_show)+sizeof($campi_show)).'>Lista Utenti</th>',$level);
			
		show4edit($table,$query_extra,$nome_campi,$campi_show,$utente,$actionframe,$button_show,$opt);		
	}

	
	addline('</td></table>',$level);
	addline('</td></table>',$level);

?>
