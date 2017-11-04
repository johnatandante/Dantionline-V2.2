<?php
	//session_start();
	
	if(!session_is_registered("extra_cartella")){
		
		session_register("extra_cartella");
		$extra_cartella=" cartella='-home-'";
	}

	$table="docs";
	
	$cartella_default = "-home-";    
	
	if($cartella!=""){
	
		$extra_cartella=" cartella='".$cartella."'";
        
	}else{
		$extra_cartella="cartella='".$cartella_default."'";
        $cartella = $cartella_default = "-home-";
               
	}
    
	$livello=getPesoClasse($utente);
	$classi=string2array(get_classiConsentite($utente)," ");

	$extra_classi=" where ".$extra_cartella." and (classe='";
	
	$i=0;
	while ($classi[$i]!=""){
		
		$extra_classi=$extra_classi."".$classi[$i]."'";
		
		$i=$i+1;
		if($classi[$i]!=""){
		
			$extra_classi=$extra_classi." or classe='";
		}else{
		
			$extra_classi=$extra_classi.")";
		}
	}


	$query_extra=$extra_classi." order by cartella,classe asc";
	$query_extra_cartelle=" order by nome,cartella,classe asc";

    
    //echo $query_extra;
    
	$id_alias="id";
	
	// numero colonne da visualizzare
	$n_rows=1000;

	$actionframe="index.php?page=gphoto&cartella=".$cartella;
	$target="default";

	$campi_select=string2array("id file cartella commento classe nome"," ");

	if($delete=="delete"){
		
		
		$campiselect=string2array("file"," ");
		$nomecampi=string2array($id_alias," ");
		$valorecampi=string2array($id,"+");
		$row=select($table,$campiselect,$nomecampi,$valorecampi,"");
		$photo=$row[0];

		delete($table,$id,$id_alias);
		$choose=1;
	}
        
    
	if($inserisci=="inserisci"){
	
        //echo '<br>uploaded? :'.is_uploaded_file($file);
        //echo '<br>file :'.$file;        
        
        if ($campo[2] != "" || $file != ""){
            $folder=$campo[2];
    		if (is_uploaded_file($file)) {    		

    			// il file avrà path pari a img/photo/utente_cartella_id_estensione
    			$newimg='public/photo/'.$utente.'_'.$folder.'_'.$file_name;
                //echo '<br>file :'.$newimg;

    			copy($file, $newimg);

    			$campo[1]=$newimg;
                
            }else if ($campo[1] != "" && ($file == "" || $file == none) ){
                //echo 'alternativa 2';
                //  si mette il path a mano
                $newimg = $campo[1];
                $error_message= "";

            }
            
            if($campo[2]==""){
            
                $folder="-home-";
                
            }            
            $campo[2]=$folder;
            
            add_record($table,$campo);
            $choose=1;

        }else{
			 
            $error_message="file_not_uploaded";
            $choose=2;
		}
	}

	if($update=="update"){
		
        if($campo[2]==""){
            
            $campo[2]="-home-";            
        }
            
		// non ci dovrebbero essere problemi
		update($table,$campi_select,$campo);
		$choose=1;
	}

	addline('<table class="centered" width="100%"  valign="top">',$level);
	addline('<tr> <th class="menu">Gestione Foto</th>',$level);
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

		addline('<tr><th class="menu_2"><a class="menulink"   href="'.$actionframe.'&choose=2">Aggiungi Foto</a></th>',$level);
	}else{

        $valore_campi[4]=get_classiConsentite($utente);
		$valore_campi[5]=$utente;
		$hide=string2array("id nome"," ");
		$mode="add";

		addline('<tr> <th class="menu_2" colspan=2>Aggiungi Foto</th>',$level);
		print_errorMessage($error_message);
		$error_message="";
		form($table,$campi_select,$valore_campi,$hide,$actionframe,$target,$mode,$utente);
	}
	addline('</td></table>',$level);
	
	addline('<tr><td><table class="centered" width="95%"  valign="top" align="center">',$level);
	
	$direzione=$avanti.''.$indietro;
	
	if ($choose!=1 && $direzione=="" && $go=="" && $edit!="edit"){
		addline('<tr><th class="menu_2"><a class="menulink"   href="'.$actionframe.'&choose=1">ritorna a: Foto Album</a></th>',$level);
	}else{		
		
		if($edit=="edit"){
			$actionframe = $actionframe.'&categoria='.$categoria;			
			$button_show=string2array("reset update",$delimitatore);
			$hide=string2array("id nome"," ");
			addline('<tr><th class="menu_2" colspan=2>Modifica foto</th>',$level);
			editrow($table,$id,$campi_select,$hide,$button_show,$actionframe,$target,$utente);
            addline('<tr><th class="menu_2" colspan=2><a class="menulink" href="'.$actionframe.'&choose=1">Ritorna</a></th>',$level);

		}else{
		
			addline('<tr> <th class="menu_2" colspan=6>Visualizza Foto</th>',$level);
			
			// bottoni da mostrare
			$button_show=string2array("edit delete"," ");

			// campi da visualizzare		
			$campi_show=string2array("file commento classe nome"," ");
			
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
			close_dbconnection($conn);
			addline('</select>',$level);
			addline('<input type="submit" name="go" value="go!">',$level);
			addline('</form></td>',$level);

			// opzioni speciali
			$opt=string2array("messagelength 35 from ".$from." to ".$to," ");
            $actionframe=$actionframe;//:.'&cartella='.$cartella;
			//show for editing
            
			show4edit($table,$query_extra,$campi_select,$campi_show,$utente,$actionframe,$button_show,$opt);
		}
	}

	addline('</td></table>',$level);
	addline('</td></table>',$level);

?>
