<?php

	session_start();

	$table="guestbook";
	$query_extra="order by id desc";
	$actionframe="index.php?page=guestb";
	$target="default";
	$n_rows="20";
	$direzione=$avanti.''.$indietro;
	$id_alias="id";

	if($inserisci=="inserisci"){
		
		if(validid($campo[0],$id_alias,$table) && notnull($campo[7])==1){
				
			if(!notnull($campo[3])){
			
				$campo[3]=$utente;
			}
			
			add_record($table,$campo);
			$choose=2;
		}else{

			if(validid($campo[0],$id_alias,$table)){
				
				$error_message="invalid_entry_guestbook";				
			}

			$choose=1;
		}
		
	}


	
	if($elimina=="elimina"){
		
		delete($table,$id,$id_alias);
		$choose=2;
	}

	addline('<body class="redpassion">', $level);
	addline('<table class="centered" width="100%"  valign="top">', $level);
	addline('<tr> <th class="menu">Guestbook</th>', $level);
	addline('<tr> <td><br></td>', $level);

	addline('<tr><td><table width="95%" align="center" class="left">', $level);
	if($choose!=1 && $choose!=2){
			$choose=2;
	}

	if($choose==1){

		addline('<tr><th class="menu_2" colspan=2>Firma il Guestbook anche tu!</th>', $level);
		
		print_errorMessage($error_message);
		$error_message="";

		$nome_campi=string2array("id data ip visitatore sitoweb mail luogo messaggio"," ");
		$i=1;
		$valorecampi[$i++]=date("Y-m-d");
		$valorecampi[$i++]=$_SERVER['REMOTE_ADDR'];

		$mode="add";

		if($utente!="anonymous" && $utente!=""){
			
			// utente conosciuto: bisogna mettere meno campi
			$hide=string2array("id data ip visitatore sitoweb mail"," ");
			$valorecampi[$i++]=$utente;
			$valorecampi[$i++]=$sito;
			$valorecampi[$i++]=$mail;
		}else{
			// utente sconosciuto: deve mettere tanti campi
			$hide=string2array("id data ip"," ");			
		}

		form($table,$nome_campi,$valorecampi,$hide,$actionframe,$target,$mode,$utente);
		
	}else{

		addline('<tr><th class="menu_2" colspan=2><a class="menulink" href="'.$actionframe.'&choose=1">Firma il Guestbook anche tu!</a></th>', $level);
	}

	addline('</table>', $level);

	addline('<tr><td><table width="95%" align="center" class="left">', $level);	
	if($choose==2 || $direzione!="" || $mostra=="mostra" || $inizio!=""){

		addline('<tr><th class="menu_2" colspan=10>Il guestbook</th>', $level);

		// visualizza il GuestBook
		$campi_select=string2array("id data ip visitatore sitoweb mail luogo messaggio"," ");

		addline('<tr><td><br></td>', $level);

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

		if($mostra!="mostra"){

			// bottoni da visualizzare
			if (isadmin($utente)==1){

				$button_show=string2array("mostra elimina"," ");
			}else{

				$button_show=string2array("mostra"," ");
			}

			// campi su cui fare la select campi da visualizzare			
			$campi_show=string2array("data visitatore messaggio"," ");
			$opt=string2array("messagelength 35 from ".$from." to ".$to," ");
			show4edit($table,$query_extra,$campi_select,$campi_show,$utente,$actionframe,$button_show,$opt);

		}else if($mostra=="mostra"){
		
			$button_show=string2array("elimina"," ");
			$hide=string2array("id ip"," ");
			$target="default";
			$actionframe=$actionframe.'&inizio='.$from;
			
			// la variabile di nome "$id" è la variabile che tiene il valore del campo "id" della
			// tabella guestbook passata dalla funzione show4edit
			showrow($table,$id,$campi_select,$hide,$utente,$button_show,$actionframe,$target);

			addline('<tr><td><br></td>', $level);
			addline('<tr><th class="menu_2" colspan='.(sizeof($button_show)+sizeof($campi_select)).'><a class="menulink" href="'.$actionframe.'">Ritorna</a></th>', $level);
		}
		
	}else{
		
		addline('<tr><th class="menu_2" colspan=2><a class="menulink" href="'.$actionframe.'&choose=2">Guarda il guestbook </a></th>', $level);
	}
	addline('</td></table>', $level);
	addline('</table>', $level);
?>
