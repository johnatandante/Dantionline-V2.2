<?php

	session_start();

	$table="articoli";
	$id_alias="id";
	$query_extra=" order by titolo";
	$delimitatore=" ";
		
	$cartella_default = "-home-";

	// opzioni speciali
	$opt="";

	// numero righe da visualizzare
	$n_rows=10;
	$direzione=$avanti.''.$indietro;

	if(!session_is_registered("extra_cartella_gart")){
		
		session_register("extra_cartella_gart");
		$extra_cartella_gart="";
	}


	if($cartella!=""){
	
		$extra_cartella_gart="cartella='".$cartella."' and ";
	}else{
		if($direzione==""){
			$extra_cartella_gart="cartella='".$cartella_default."' and ";
            $cartella=$cartella_default;
		}


	}

	// actionframe
	$actionframe="index.php?page=garticoli&cartella=".$cartella;	
	$target="default";

	$livello=getPesoClasse($utente);
	$classi=string2array(get_classiConsentite($utente)," ");	

	$extra_classi=" where ".$extra_cartella_gart." (classe='";
	$extra_classi2=" where (classe='";
	
	$i=0;
	while ($classi[$i]!=""){

		$extra_classi=$extra_classi."".$classi[$i]."'";
		$extra_classi2=$extra_classi2."".$classi[$i]."'";
		
		$i=$i+1;
		if($classi[$i]!=""){
		
			$extra_classi=$extra_classi." or classe='";
			$extra_classi2=$extra_classi2." or classe='";
		}else{
		
			$extra_classi=$extra_classi.")";
			$extra_classi2=$extra_classi2.")";
		}
	}

	$query_extra=$extra_classi." order by titolo";
	$query_extra_cartelle=$extra_classi2." order by cartella";

	$id_alias="id";
	
	$campi_select=string2array("id data classe cartella titolo file link articolo autore extra"," ");

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

	$articolo=$campo[7];

	if($inserisci=="inserisci" || $update=="update"){
		
		if(notnull($articolo)){
			
			$folder=$campo[3];
					
			if($folder==""){
			
				$folder="-home-";
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
            
            
			if (is_uploaded_file($file)) {
				//echo 'alternativa 1';
				// il file avrà path pari a img/photo/utente_cartella_id_estensione
                // si da la precedenza al file che si sta uploadando
				$newdoc='public/docs/'.$utente.'_'.$folder.'_'.$file_name;
				
				copy($file, $newdoc);
				$documento=$newdoc;
			}else if ($campo[5] != "" && ($file == "" || $file == none) ){
                //echo 'alternativa 2';
                //  si mette il path a mano
                $documento = $campo[5];
                $error_message= "";
                    
            }else{
                $error_message="file_not_uploaded";
                $documento = "";
            }
            
            if ($folder!=""){
                $campo[3]=$folder;
                
            }else{
                $campo[3] = "-home-";
            }
            
			$campo[5]=$documento;
			
			if ($inserisci=="inserisci"){
				
				// modalità add
				if(validid($campo[0],$id_alias,$table)){
		
					add_record($table,$campo);
					$choose=1;
					
				}

			}else{

				//modalità edit
				$campo[1]=date("Y-m-d");
				
				update($table,$campi_select,$campo);
				$choose=1;

			}
		}else{
					
			$error_message="no_data";
			$choose=2;
		}
	}

	addline('<TABLE class="centered" width="100%"  valign="top">',$level);
	addline('<tr> <th class="menu">Gestione Articoli</th>',$level);
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
		
		addline('<tr><th class="menu_2"><a class="menulink" href="'.$actionframe.'&choose=2">Aggiungi un articolo</a></th>',$level);
			
	}else if($choose==2) {
	
		addline('<tr><th class="menu_2" colspan=2>Nuovo articolo</th>',$level);

		print_errorMessage($error_message);
		$error_message="";
		
		$valorecampi[1]=date("Y-m-d");
		$valorecampi[2]=get_classiConsentite($utente);
		$valorecampi[8]=$utente;
		
		$hide=string2array("id data autore"," ");		
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
			$hide=string2array("id data autore"," ");
			addline('<tr><th class="menu_2" colspan='.(sizeof($button_show)+sizeof($nome_campi)-sizeof($hide)).'>Modifica articolo</th>',$level);
			editrow($table,$id,$nome_campi,$hide,$button_show,$actionframe,$target,$utente);
            addline('<tr><th class="menu_2" colspan=2><a class="menulink" href="'.$actionframe.'&choose=1">Ritorna</a></th>',$level);

		}else if($mostra=="mostra"){
			$actionframe = $actionframe.'&categoria='.$categoria;
			$button_show=string2array(""," ");
			$hide=string2array("id data"," ");
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
			$campi_show=string2array("data classe titolo autore"," ");			
			
			addline('<tr><th class="menu_2" colspan='.(sizeof($button_show)+sizeof($campi_show)).'>Lista Articoli</th>',$level);

			$conn=open_dbconnection("default");
			$sql='select distinct cartella from '.$table.' '.$query_extra_cartelle;
			$res=run_sql($sql,$conn);
			$row = mysqli_fetch_assoc($res);
			
			addline('<tr><td colspan=7 align="right"><form action="'.$actionframe.'" method="post" >',$level);
			addline('Cartella:<select name="cartella">',$level);

            addline('<option value="'.$cartella.'">'.$cartella.'</option>',$level);
            
			while($row[0]!=""){
                
                if($row[0] != $cartella){
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
            $actionframe=$actionframe.'&cartella='.$cartella;
			show4edit($table,$query_extra,$nome_campi,$campi_show,$utente,$actionframe,$button_show,$opt);
            
		}

	}else if($choose!=1){
	
		addline('<tr><th class="menu_2"><a class="menulink" href="'.$actionframe.'&choose=1">Ritorna</a></th>',$level);
	}
	addline('</td></table>',$level);
	addline('</td></table>',$level);
?>
