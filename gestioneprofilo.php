<?php

	$max_rows=5;
	$table="utenti";
	$actionframe="index.php?page=gprofilo&choose=".$choose;
	
	if($send=="upload"){
    		
        if(($foto!="" && $foto!=none) || $foto_raw!=""){
            if (is_uploaded_file($file)) {

    			$newimg='public/photo/foto'.$utente.'_'.$file_name;    			
    			copy($file, $newimg);
            }else{
                $newimg = $foto_raw;
                
            }
            $foto=changePicture($newimg,$foto,$utente);
			
		}else{
			 
			 $error_message="file_not_uploaded";
			 
		}
		$choose=1;
	}

	if($update=="update"){

		$nome_campi=string2array("nome descrizione classe mail sitoweb password foto commento last_login"," ");				
		$campo[4] = getRigthUrl($campo[4]);

		//echo $campo[4];

		$mail=htmlspecialchars($campo[3]);
		$sito=htmlspecialchars($campo[4]);
		$commento_utente=htmlspecialchars($campo[7]);
		update($table,$nome_campi,$campo);
        
        $simple_message = "data_updated";
	}


	if($send=="CambiaPassword"){
		
		//echo "pass: $password - $old_p *".($password==$old_p)."* newp: ($new_p - $new_p2)".($new_p==$new_p2);

		if($password==$old_p && $new_p==$new_p2){
						
			$nome_campi[0]="nome";
			$nome_campi[1]="password";
			$valore_campi[0]=$utente;
			$valore_campi[1]=$new_p;
			update($table,$nome_campi,$valore_campi);
			$password=$new_p;
			$error_message="password_changed";
			

		}else{

			$error_message="wrong_password";
		}

		$choose=0;
	}
	
	addline('<table class="centered" width="100%"  valign="top">',$level);
	addline('<tr> <th class="menu">Gestione Profilo</th>',$level);

	addline('<tr><td><br></td>',$level);
	
	//	reparto immagine
	addline('<tr><td>',$level);
	addline('<table align="center" class="centered" width="95%">',$level);

	if($error_message!=""){
	
		print_errorMessage($error_message);
		$error_message="";
	}

    if($simple_message!=""){
	
		print_simpleMessage($simple_message);
		$simple_message="";
	}
    
    $file = file_exists("tn/".$foto);
    if (!$file){
        $tn="";
    }else{
        $tn="tn/";
    }

    addline('<tr><td class="centered">',$level);
    addline('<table align="center" width="95%">',$level);    
    addline('<tr><th class="menu_2" colspan=2>Cambia Foto</th>',$level);    
    addline('<tr><td><br></td>',$level);
    addline('<tr><form enctype="multipart/form-data" action="'.$actionframe.'" method="post">',$level);
    addline('<td width="35%" class="centered"><img src="'.$tn.''.$foto.'" width=100 height=100></td>',$level);
    addline('<td align="left"><INPUT TYPE="hidden" name="MAX_FILE_SIZE" value="1000000">',$level);
    addline('<input name="file" type="file" size="15"><br>',$level);
    addline('<input name="foto_raw" type="text" size="25" value="'.$foto.'"><br><br>',$level);
    addline('<input name="send" type="submit" value="upload"></td>',$level);
    addline('</form></td>',$level);
    
    printspacer(1);
    //	reparto password
    addline('<tr><th class="menu_2" colspan=2>Cambia Password</th>',$level);
    addline('<form action="'.$actionframe.'" method="post">',$level);
    
    addline('<tr><td class="etichetta">Old Password</td><td><input type="password" name="old_p"></td>',$level);
    addline('<tr><td class="etichetta">New Password</td><td><input type="password" name="new_p"></td>',$level);
    addline('<tr><td class="etichetta">Re-Type New Password</td><td><input type="password" name="new_p2"></td>',$level);
    addline('<tr><td /><td class="left"><input name="send" type="submit" value="CambiaPassword"></td>',$level);
    addline('</form>',$level);

	addline('</td>',$level);
    addline('</td></table>',$level);
   
    printspacer(1);
	addline('<tr><td class="centered">',$level);
    addline('<table align="center" class="centered" width="95%">',$level);        

	//	reparto commento	//	reparto mail&sitoweb
	
    $target="default";
    $button_show=string2array("reset update"," ");
    $nome_campi=string2array("nome descrizione classe mail sitoweb password foto commento last_login"," ");
    $hide=string2array("nome descrizione classe password foto last_login"," ");
        
    addline('<tr><th class="menu_2" colspan='.(sizeof($button_show)+sizeof($nome_campi)).'>Dati Utente</th>',$level);
    printspacer(1);
    editrow($table,$utente,$nome_campi,$hide,$button_show,$actionframe,$target,$utente);

	addline('</td>',$level);
    addline('</td></table>',$level);

    
	addline('</table></td>',$level);
    
	addline('</table>',$level);
?>

