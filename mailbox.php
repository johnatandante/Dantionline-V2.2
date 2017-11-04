<?php

	session_start();

	$table="mail";
	$nome_campi=string2array("id data mittente destinatario messaggio nuovo"," ");
	$id_alias="id";
	$query_extra=" where destinatario='".$utente."'";
	$query_extra_mitt =$query_extra;
	$orderby = " order by id desc";
	$delimitatore=" ";
		
	// actionframe
	$actionframe="index.php?page=mailbox";	
	$target="default";
		
	// opzioni speciali
	$opt="";
	
	$n_rows="20";
	$direzione=$avanti.''.$indietro;	

	if($invia=="invia"){
		
		$stringa=find_nextIndex(get_radiceid("mail"))."+".estrai_data()."+".$utente."+".$nome."+".$sms."+sì";
		$values=string2array($stringa,"+");
		add_record("mail",$values);
	}


	if($delete=="delete"){

		delete($table,$id,$id_alias);
		$choose=1;
	}

	if($elimina=="elimina"){
		
		delete($table,$id,$id_alias);
		$choose=1;
	}

	if($inserisci=="inserisci"){
		
		add_record($table,$campo);
		$choose=1;	
	}
	
	if($mittente!=""){
	
		$query_extra=$query_extra."and mittente='".$mittente."'";
	}

	$query_extra=$query_extra.$orderby;
	$query_extra_mitt = $query_extra_mitt.$orderby;

	addline('<TABLE class="centered" width="100%"  valign="top">',$level);
	addline('<tr> <th class="menu">Mailbox</th>',$level);

	addline('<tr><td><br></td>',$level);
	addline('<tr><td><table class="centered" width="95%"  valign="top" align="center">',$level);

	if ($choose!=2 and $choose!=1){	
		$choose=1;
	}

	if($choose!=2){
		
		addline('<tr><th class="menu_2"><a class="menulink"   href="'.$actionframe.'&choose=2">Manda un messaggio ad un utente</a></th>',$level);
			
	}else if($choose==2) {
	
		addline('<tr><th class="menu_2" colspan=2>Nuovo messaggio</th>',$level);

		$hide=string2array("id data mittente nuovo"," ");
		$mode="add";
		$valorecampi[1]=estrai_data();

		$campiselect=string2array("nome"," ");
		$valorecampi[3]=array2string(select2array("utenti",$campiselect,"",""," order by nome"),",");
		$valorecampi[2]=$utente;
		$valorecampi[5]="sì";

		form($table,$nome_campi,$valorecampi,$hide,$actionframe,$target,$mode,$utente);
	}

	addline('</table></td>',$level);
	addline('<tr>',$level);
	addline('<tr><td><table class="centered" width="95%"  valign="top" align="center">',$level);
	
	if($choose==1 || $direzione!="" || $inizio!="" || "mostra"==$mostra){
	
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

		if($mostra=="mostra"){
			
			// notifica la lettura
			update($table,string2array("id nuovo"," "),string2array($id."+no","+"));

			$button_show=string2array("elimina InviaMessaggio"," ");
			$hide=string2array("id data destinatario nuovo"," ");
			$actionframe=$actionframe.'&inizio='.$from;
			$target="default";
			
			$mittente=select("mail",string2array("mittente"," "),string2array("id"," "),string2array($id,"+"),"");

			addline('<tr><td class="menu_2" colspan=2>Message from '.$mittente[0].'</td>',$level);
			// la variabile di nome "$id" è la variabile che tiene il valore del campo "id" della
			// tabella guestbook passata dalla funzione show4edit
			showrow($table,$id,$nome_campi,$hide,$utente,$button_show,$actionframe,$target);




			addline('<tr><th class="menu_2" colspan=2><a class="menulink"  href="'.$actionframe.'">Ritorna</a></th>',$level);

		}else{

			$conn=open_dbconnection("default");
			$sql='select distinct mittente from '.$table.' '.$query_extra_mitt;
			$res=run_sql($sql,$conn);
			$row = mysqli_fetch_assoc($res);
			
			// opzioni speciali
			$opt=string2array("messagelength 45 from ".$from." to ".$to." nuovo"," ");

			// bottoni da visualizzare
			$button_show=string2array("mostra delete"," ");

			// campi su cui fare la select campi da visualizzare
			$campi_show=string2array("data mittente messaggio"," ");			
			
			addline('<tr><th class="menu_2" colspan='.(1+(sizeof($button_show)+sizeof($campi_show))).'>Lista Messaggi</th>',$level);

			addline('<tr><td colspan=7 align="right"><form action="'.$actionframe.'" method="post" >',$level);
			addline('Mittente:<select name="mittente">',$level);

			addline('<option value="'.$mittente.'">'.$mittente.'</option>',$level);
                    
            while($row[0]!=""){
                
                if($row[0] != $mittente){
                    addline('<option value="'.$row[0].'">'.$row[0].'</option>',$level);
                    $row = mysqli_fetch_assoc($res);
                }else{
                    $row = mysqli_fetch_assoc($res);
                }
            }
			addline('</select>',$level);
			addline('<input type="submit" name="go" value="go!">',$level);
			addline('</form></td>',$level);

			show4edit($table,$query_extra,$nome_campi,$campi_show,$utente,$actionframe,$button_show,$opt);
		}

	}else if($choose!=1){
	
		addline('<tr><th class="menu_2"><a class="menulink" href="'.$actionframe.'&choose=1">Ritorna a : messaggi</a></th>',$level);
	}
	addline('</td></table>',$level);
	addline('</td></table>',$level);
?>
