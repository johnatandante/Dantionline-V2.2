<?php

	session_start();

	if(!session_is_registered("extra_utente")){
		
		session_register("extra_utente");
		$extra_utente="";
	}


	if($visitatore==""){
		$visitatore = "anonymous";
    }
    $extra_utente=" where nome='".$visitatore."'";
	

	$table="accessi";
	$id_alias="id";

	$query_extra= $extra_utente." order by id desc";
		
	// actionframe
	$actionframe="index.php?page=gaccessi";	
	$target="default";
		
	// opzioni speciali
	$n_rows=20;
	$direzione=$avanti.''.$indietro;

	if($elimina=="elimina" || $delete=="delete"){
		
		delete($table,$id,$id_alias);
		$choose=1;
	}

	addline('<TABLE class="centered" width="100%"  valign="top">',$level);
	addline('<tr> <th class="menu">Admin Accessi</th>',$level);

	addline('<tr><td><br></td>',$level);

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
		
	if($mostra=="mostra"){
	
		$nome_campi=string2array("id ip_address browser data ora nome"," ");

		$button_show=string2array("elimina"," ");
		$hide=string2array("id"," ");
		$actionframe=$actionframe.'&inizio='.$from;
		$target="default";
		
		addline('<tr><th class="menu_2" colspan=2><a class="menulink" href="'.$actionframe.'">Elemento '.$id.'</a></th>',$level);
		addline('<tr><td><br></td>',$level);

		// la variabile di nome "$id" è la variabile che tiene il valore del campo "id" della
		// tabella guestbook passata dalla funzione show4edit
		showrow($table,$id,$nome_campi,$hide,$utente,$button_show,$actionframe,$target);

		addline('<tr><td><br></td>',$level);
		addline('<tr><th class="menu_2" colspan=2><a class="menulink"  href="'.$actionframe.'">Ritorna</a></th>',$level);

	}else{
		
		// opzioni speciali
		$opt=string2array("messagelength 20 from ".$from." to ".$to," ");

		// bottoni da visualizzare
		$button_show=string2array("mostra delete"," ");

		// campi su cui fare la select campi da visualizzare
		$campi_select=string2array("id ip_address browser data ora nome"," ");
		$campi_show=string2array("ip_address data ora"," ");
		
		addline('<tr><th class="menu_2" colspan='.(sizeof($button_show)+sizeof($campi_show)).'>Lista Utenti</th>',$level);

		$conn=open_dbconnection("default");
		$sql='select distinct nome from '.$table.' order by nome';
		$res=run_sql($sql,$conn);
		$row = mysqli_fetch_assoc($res);
		
		addline('<tr><td colspan=5 align="right"><form action="'.$actionframe.'" method="post" >',$level);
		addline('Visitatore:<select name="visitatore">',$level);

		addline('<option value="'.$visitatore.'">'.$visitatore.'</option>',$level);
                    
        while($row[0]!=""){
            
            if($row[0] != $visitatore){
                addline('<option value="'.$row[0].'">'.$row[0].'</option>',$level);
                $row = mysqli_fetch_assoc($res);
            }else{
                $row = mysqli_fetch_assoc($res);
            }
        }
		addline('</select>',$level);
		addline('<input type="submit" name="go" value="go!">',$level);
		addline('</form></td>',$level);

		close_dbconnection($conn);		
					
		show4edit($table,$query_extra,$campi_select,$campi_show,$utente,$actionframe,$button_show,$opt);		
	}

	
	addline('</td></table>',$level);
	addline('</td></table>',$level);

?>
