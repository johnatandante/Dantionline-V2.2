<?php
    if(!session_is_registered("extra_categoria_downl")){
		
		session_register("extra_categoria_downl");
		$extra_categoria_downl="";
	}

	$table="downloads";
	$id_alias="id";
	$query_extra=" order by categoria";
	$delimitatore=" ";
    
    $categoria_default = "-home-";

	// opzioni speciali
	$opt="";

	// numero righe da visualizzare
	$n_rows=10;
	$direzione=$avanti.''.$indietro;

	if($categoria!=""){
		$extra_categoria_downl="categoria='".$categoria."' and ";

	}else{
		if($direzione==""){
			$extra_categoria_downl="categoria='".$categoria_default."' and ";
            $categoria=$categoria_default;
		}

	}
    //echo 'extra_categoria_downl: '.$extra_categoria_downl;

	// actionframe
	$actionframe="index.php?page=gdownloads";	
	$target="default";

	$livello=getPesoClasse($utente);
	$classi=string2array(get_classiConsentite($utente)," ");	

	$extra_classi=" where ".$extra_categoria_downl." (classe='";
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

	$query_extra=$extra_classi." order by data desc";
	$query_extra_cartelle=$extra_classi2." order by categoria";

	$id_alias="id";
	
	$campi_select=string2array("id data classe categoria link descrizione autore"," ");

	if($delete=="delete" || $elimina=="elimina"){
		delete($table,$id,$id_alias);
		$choose=1;
	}

	$nome_campi=$campi_select;	

	$articolo=$campo[5];

	if($inserisci=="inserisci" || $update=="update"){
		
		if(notnull($articolo)){
			
			$folder=$campo[3];
					
			if($folder==""){
			
				$folder="-home-";
			}
				
			$campo[3]=$folder;
			
			if ($inserisci=="inserisci"){
				
				// modalità add
				if(validid($campo[0],$id_alias,$table)){
		
					add_record($table,$campo);
					$choose=1;
				}else{
                    $error_message="internal_error";
        			$choose=2;
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
	addline('<tr> <th class="menu">Gestione Downloads</th>',$level);
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
		
		addline('<tr><th class="menu_2"><a class="menulink" href="'.$actionframe.'&choose=2">Aggiungi un downloads</a></th>',$level);
			
	}else if($choose==2) {
	
		addline('<tr><th class="menu_2" colspan=2>Nuovo Download</th>',$level);

		print_errorMessage($error_message);
		$error_message="";
		
		$valorecampi[1]=date("Y-m-d");
		$valorecampi[2]=get_classiConsentite($utente);
		$valorecampi[6]=$utente;
		
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
            addline('<tr><th class="menu_2" colspan=2><a class="menulink"  href="'.$actionframe.'">Ritorna</a></th>',$level);

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
			$campi_show=string2array("data classe autore"," ");			
			
			addline('<tr><th class="menu_2" colspan='.(sizeof($button_show)+sizeof($campi_show)).'>Lista Downloads</th>',$level);

			$conn=open_dbconnection("default");
			$sql='select distinct categoria from '.$table.' '.$query_extra_cartelle;
			$res=run_sql($sql,$conn);
			$row = mysqli_fetch_assoc($res);
			
			addline('<tr><td colspan=7 align="right"><form action="'.$actionframe.'" method="post" >',$level);
			addline('Categoria:<select name="categoria">',$level);

			addline('<option value="'.$categoria.'">'.$categoria.'</option>',$level);
            
			while($row[0]!=""){
                
                if($row[0] != $categoria){
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

            $actionframe=$actionframe.'&categoria='.$categoria;

			show4edit($table,$query_extra,$nome_campi,$campi_show,$utente,$actionframe,$button_show,$opt);		
		}

	}else if($choose!=1){
	
		addline('<tr><th class="menu_2"><a class="menulink" href="'.$actionframe.'&choose=1">Visualizza lista Downloads</a></th>',$level);
	}
	addline('</td></table>',$level);
	addline('</td></table>',$level);
?>
