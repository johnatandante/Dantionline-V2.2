<?php

	session_start();

	$table="classi";
	$id_alias="classe";
	$query_extra=" order by ".$id_alias;
	$delimitatore=" ";
		
	// actionframe
	$actionframe="index.php?page=gclassi";	
	$target="default";
		
	// opzioni speciali
	$opt="";
	
	$n_rows="10";
	$direzione=$avanti.''.$indietro;

	if($delete=="delete"){

		delete($table,$nomeclasse,$id_alias);
		$choose=1;
	}
	if($elimina=="elimina"){
		
		echo "$table,$nomeclasse,$id_alias ".$table.",".$nomeclasse.",".$id_alias;
		delete($table,$nomeclasse,$id_alias);
		$choose=1;
	}

	if($inserisci=="inserisci"){
		
		if(validid($campo[0],$id_alias,$table)){
		
			add_record($table,$campo);
			$choose=1;	
		}else{
			
			$error_message="invalid_name";
			$choose=2;	
		}
		
	}

	if($update=="update"){

		$nome_campi=string2array("classe livello"," ");
		update($table,$nome_campi,$campo);
		$choose=1;
	}
	

	addline('	<TABLE class="centered" width="100%"  valign="top">',$level);
	addline('	<tr> <th class="menu">Admin Classi</th>',$level);

	addline('<tr><td><br></td>',$level);
	addline('<tr><td><table class="centered" width="95%"  valign="top" align="center">',$level);

	if($choose!=2 && $choose!=1){
		$choose =1;	
	}

	if($choose!=2){
		
		addline('<tr><th class="menu_2"><a class="menulink" href="'.$actionframe.'&choose=2">Aggiungi una Classe di Utente</a></th>',$level);
			
	}else if($choose==2) {
	
		addline('<tr><th class="menu_2" colspan=2>Nuova Classe</th>',$level);

		print_errorMessage($error_message);
		$error_message="";

		$nome_campi=string2array("classe livello"," ");
		$hide=string2array(""," ");
		$mode="add";

		form($table,$nome_campi,$valorecampi,$hide,$actionframe,$target,$mode,$utente);
        
	}

	addline('</td></table>',$level);
	addline('<tr>',$level);

	addline('<tr><td><table class="centered" width="95%"  valign="top" align="center">',$level);
	
	if($choose==1 || $edit=="edit" || $direzione!="" || $inizio!="" || "mostra"==$mostra){
	
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

		if($edit=="edit"){
		
			$button_show=string2array("reset update",$delimitatore);
			$nome_campi=string2array("classe livello"," ");
			$hide=string2array("classe"," ");
			addline('<tr><th class="menu_2" colspan='.(sizeof($button_show)+sizeof($nome_campi)-sizeof($hide)).'>Modifica livello classe "'.$nomeclasse.'"</th>',$level);
			
			editrow($table,$nomeclasse,$nome_campi,$hide,$button_show,$actionframe,$target,$utente);
            addline('<tr><th class="menu_2" colspan=2><a class="menulink" href="'.$actionframe.'">Ritorna</a></th>',$level);

		}else if($mostra=="mostra"){
		
			$nome_campi=string2array("classe livello"," ");

			$button_show=string2array("elimina"," ");
			$hide=string2array(""," ");
			$actionframe=$actionframe.'&inizio='.$from;
			$target="default";
			
			// la variabile di nome "$id" � la variabile che tiene il valore del campo "id" della
			// tabella guestbook passata dalla funzione show4edit		
			showrow($table,$nomeclasse,$nome_campi,$hide,$utente,$button_show,$actionframe,$target);			

			addline('<tr><td><br></td>',$level);
			addline('<tr><th class="menu_2" colspan=2><a class="menulink" href="'.$actionframe.'">Ritorna</a></th>',$level);

		}else{

			// opzioni speciali
			$opt=string2array("messagelength 25 from ".$from." to ".$to," ");

			// bottoni da visualizzare
			$button_show=string2array("mostra edit delete"," ");

			// campi su cui fare la select campi da visualizzare
			$campi_select=string2array("classe livello"," ");
			$campi_show=string2array("classe livello"," ");			
			
			addline('<tr><th class="menu_2" colspan='.(sizeof($button_show)+sizeof($campi_show)).'>Lista Classi</th>',$level);
			show4edit($table,$query_extra,$campi_select,$campi_show,$utente,$actionframe,$button_show,$opt);		
		}

	}else if($choose!=1){
	
		addline('<tr><th class="menu_2"><a class="menulink" href="'.$actionframe.'&choose=1">Visualizza lista classi</a></th>',$level);
	}
	addline('</td></table>',$level);
	addline('</td></table>',$level);

?>
