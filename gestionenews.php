<?php

	session_start();	

	$max_rows=-1;
	$table="news";
	$query_extra="order by id desc";
	$colspan=5;
	$id_alias="id";
	
	// numero colonne da visualizzare
	$n_rows=20;

	$actionframe="index.php?page=gnews";
	$target="default";

	$campi_select=string2array("id data messaggio nome"," ");

	if($delete=="delete"){
		
		delete($table,$id,$id_alias);
		$choose=1;
	}

	if($inserisci=="inserisci"){
		if(notnull($campo[3])){
			add_record($table,$campo);
			$choose=1;
		}else{

			$error_message="no_data";
			$choose=2;
		}
		
	}

	addline('<table class="centered" width="100%"  valign="top">',$level);
	addline('<tr> <th class="menu">Gestione News</th>',$level);
	addline('<tr><td><br></td>',$level);

	addline('<tr><td><table class="centered" width="95%"  valign="top" align="center">',$level);
	
	if($choose!=2 && $choose!=1){
		$choose =1;	
	}

	if($choose!=2){

		addline('<tr><th class="menu_2"><a class="menulink" href="'.$actionframe.'&choose=2">Aggiungi News</a></th>',$level);
	}else{

		$valore_campi[3]=$utente;
		$valore_campi[1]=date("Y-m-d");
		$hide=string2array("id data nome"," ");
		$mode="add";

		addline('<tr> <th class="menu_2" colspan=2>Aggiungi News</th>',$level);
		
		print_errorMessage($error_message);
		$error_message="";
		
		form($table,$campi_select,$valore_campi,$hide,$actionframe,$target,$mode,$utente);
	}
	addline('</td></table>',$level);
	
	addline('<tr><td><table class="centered" width="95%"  valign="top" align="center">',$level);
	
	$direzione=$avanti.''.$indietro;
	
	if ($choose!=1 && $direzione==""){
		addline('<tr><th class="menu_2"><a class="menulink"   href="'.$actionframe.'&choose=1">Ritorna a: News</a></th>',$level);
	}else{
	
		addline('<tr> <th class="menu_2" colspan=4>Visualizza News</th>',$level);
		// bottoni da mostrare
		$button_show=string2array("delete"," ");

		// campi su cui fare la select e campi da visualizzare
		
		$campi_show=string2array("data messaggio"," ");
		
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

		// opzioni speciali
		$opt=string2array("messagelength 35 from ".$from." to ".$to." AddedBy"," ");

		//show for editing
		show4edit($table,$query_extra,$campi_select,$campi_show,$utente,$actionframe,$button_show,$opt);
	}

	addline('</td></table>',$level);
	addline('</td></table>',$level);
?>

