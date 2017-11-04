<?php

	session_start();

	$table="music";
	$id_alias="id";
	$query_extra=" order by gruppo";
	$delimitatore=" ";
		
	$genere_default = "none";

	// opzioni speciali
	$opt="";

	// numero righe da visualizzare
	$n_rows=10;
	$direzione=$avanti.''.$indietro;

	if(!session_is_registered("extra_genere_gmus")){
		
		session_register("extra_genere_gmus");
		$extra_genere_gmus="";
	}


	if($genere!=""){
	
		$extra_genere_gmus="genere='".$genere."' ";
	}else{
		if($direzione==""){
			$extra_genere_gmus="genere='".$genere_default."' ";
            $genere=$genere_default;
		}
	}

	// actionframe
	$actionframe="index.php?page=gmusic&genere=".$genere;	
	$target="default";

	$livello=getPesoClasse($utente);
			
	$query_extra=" where ".$extra_genere_gmus." order by gruppo";
	$query_extra_cartelle=" order by genere";
	
	$campi_select=string2array("id genere gruppo album file canzoni anno supporto extra"," ");

	if($delete=="delete" || $elimina=="elimina"){
		
		$campiselect=string2array("file"," ");
		$nomecampi=string2array($id_alias," ");
		$valorecampi=string2array($id,"+");

		// cancellazionw della foto
		$row=select($table,$campiselect,$nomecampi,$valorecampi,"");
		$photo=$row[0];

		delete($table,$id,$id_alias);
		$choose=1;
	}

	$nome_campi=$campi_select;	

	$canzoni=$campo[7];

	if($inserisci=="inserisci" || $update=="update"){
		
		if(notnull($canzoni)){
			
			$genre=$campo[1];
					
			if($genre==""){
			
				$genre="none";
			}
				
			// cancellazione del documento preesistente
			if($update=="update"){
				$id = $campo[0];

				// reperimento del documento
				$campiselect=string2array("file"," ");
				$nomecampi=string2array($id_alias," ");
				$valorecampi=string2array($id,"+");

				// edit della foto
				$row=select($table,$campiselect,$nomecampi,$valorecampi,"");				
				$documento=$row[0];
				
			}
            
            //echo 'campo5: '.$campo[5];
            //echo ' file: '.$file;
            
			if (is_uploaded_file($file)) {
				//echo 'alternativa 1';
				// il file avrà path pari a img/photo/utente_genere_id_estensione
                // si da la precedenza al file che si sta uploadando
				$newdoc='public/docs/'.$utente.'_'.$genre.'_'.$file_name;
				
				copy($file, $newdoc);
				$documento=$newdoc;
			}else if ($campo[4] != "" && ($file == "" || $file == none) ){
                //echo 'alternativa 2';
                //  si mette il path a mano
                $documento = $campo[4];
                $error_message= "";
                    
            }else{
                $error_message="file_not_uploaded";
                $documento = "";
            }
                

			$campo[1]=$genre;
			$campo[4]=$documento;
			
			if ($inserisci=="inserisci"){
				
				// modalità add
				if(validid($campo[0],$id_alias,$table)){
		
					add_record($table,$campo);
					$choose=1;
					
				}

			}else{

				//modalità edit
                update($table,$campi_select,$campo);
				$choose=1;

			}
		}else{
					
			$error_message="no_data";
			$choose=2;
		}
	}

	addline('<TABLE class="centered" width="100%"  valign="top">',$level);
	addline('<tr> <th class="menu">Gestione Musica</th>',$level);
    if($error_message!=""){
	
		print_errorMessage($error_message);
		$error_message="";
	}else{
        $error_message="";
    }


	addline('<tr><td><br></td>',$level);
	addline('<tr><td><table class="centered" width="95%"  valign="top" align="center">',$level);
	
	if($choose!=2 && $choose!=1){
		$choose =1;	
	}

	if($choose!=2){
		
		addline('<tr><th class="menu_2"><a class="menulink" href="'.$actionframe.'&choose=2">Aggiungi un canzoni</a></th>',$level);
			
	}else if($choose==2) {
	
		addline('<tr><th class="menu_2" colspan=2>Nuovo Album</th>',$level);

		print_errorMessage($error_message);
		$error_message="";
		
		$valorecampi[1]=get_lista("genere");
		$valorecampi[7]=get_lista("supporto");
		
		$hide=string2array("id"," ");
		$mode="add";

		form($table,$nome_campi,$valorecampi,$hide,$actionframe,$target,$mode,$utente);
	}

	addline('</td></table>',$level);
	addline('<tr>',$level);

	addline('<tr><td><table class="centered" width="95%"  valign="top" align="center">',$level);
	
	if($choose==1 || $edit=="edit" || $direzione!="" || $inizio!="" || "mostra"==$mostra || $go!=""){
	
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
			$actionframe = $actionframe.'&categoria='.$categoria;
			$button_show=string2array("reset update",$delimitatore);
			$hide=string2array("id"," ");
			addline('<tr><th class="menu_2" colspan='.(sizeof($button_show)+sizeof($nome_campi)-sizeof($hide)).'>Modifica album</th>',$level);
			editrow($table,$id,$nome_campi,$hide,$button_show,$actionframe,$target,$utente);
            addline('<tr><th class="menu_2" colspan=2><a class="menulink" href="'.$actionframe.'&choose=1">Ritorna</a></th>',$level);

		}else if($mostra=="mostra"){
			$actionframe = $actionframe.'&categoria='.$categoria;
			$button_show=string2array(""," ");
			$hide=string2array("id"," ");
			$actionframe=$actionframe.'&inizio='.$from;
			$target="default";
			
			// la variabile di nome "$id" è la variabile che tiene il valore del campo "id" della
			// tabella guestbook passata dalla funzione show4edit
			showrow($table,$id,$nome_campi,$hide,$utente,$button_show,$actionframe,$target);

			addline('<tr><td><br></td>',$level);
			addline('<tr><th class="menu_2" colspan=2><a class="menulink"  href="'.$actionframe.'">Ritorna</a></th>',$level);

		}else{
			
			// opzioni speciali
			$opt=string2array("messagelength 25 from ".$from." to ".$to," ");
						
			// bottoni da visualizzare
			$button_show=string2array("mostra edit delete"," ");

			// campi su cui fare la select campi da visualizzare
			$campi_show=string2array("gruppo album anno"," ");			
			
			addline('<tr><th class="menu_2" colspan='.(sizeof($button_show)+sizeof($campi_show)).'>Lista Album</th>',$level);

			$conn=open_dbconnection("default");
			$sql='select distinct genere from '.$table.' '.$query_extra_cartelle;
			$res=run_sql($sql,$conn);
			$row = mysqli_fetch_assoc($res);
			
			addline('<tr><td colspan=7 align="right"><form action="'.$actionframe.'" method="post" >',$level);
			addline('genere:<select name="genere">',$level);

			while($row[0]!=""){
			
				addline('<option value="'.$row[0].'">'.$row[0].'</option>',$level);
				$row = mysqli_fetch_assoc($res);
			}
			addline('</select>',$level);
			addline('<input type="submit" name="go" value="go!">',$level);
			addline('</form></td>',$level);

			close_dbconnection($conn);
            $actionframe=$actionframe.'&genere='.$genere;
            //echo 'extra: '.$query_extra;
			show4edit($table,$query_extra,$nome_campi,$campi_show,$utente,$actionframe,$button_show,$opt);		
		}

	}else if($choose!=1){
	
		addline('<tr><th class="menu_2"><a class="menulink" href="'.$actionframe.'&choose=1">Ritorna</a></th>',$level);
	}
	addline('</td></table>',$level);
	addline('</td></table>',$level);
?>
