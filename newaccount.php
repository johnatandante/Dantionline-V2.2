<?php

	session_start();

	$table="utenti";
	
	// actionframe
	$actionframe="index.php?page=newutente";
	//$target="user_main";


	addline('<table class="centered" width="100%"  valign="top">',$level);
	addline('<tr> <th class="menu">Nuovo Account</th>',$level);
	addline('<tr> <td><br></td>',$level);
	
	addline('<tr><td><table width="95%" align="center" class="left">',$level);
	if($choose==1){
        $actionframe="index.php?page=in&new=1";
		addline('<td align="center">',$level);
		addline('<table width="80%">',$level);
		addline('<tr><th class="menu_2" colspan=2>Dati personali </th>',$level);
		addline('<tr>',$level);

		if($invalidname==1){
			print_errorMessage("invalid_name");			
		}	

		$hide=string2array("descrizione classe foto last_login"," ");
		$nome_campi=string2array("nome descrizione classe mail sitoweb password foto commento last_login"," ");	
		$valorecampi[1]="Nuovo utente";
		$valorecampi[2]="blog";
		$valorecampi[6]="img/photo/default.gif";
		$mode="add";

		form($table,$nome_campi,$valorecampi,$hide,$actionframe,$target,$mode,$utente);
        addline('</table>',$level);
	}else{

		addline('<tr><th class="menu_2">Avviso</a></th>',$level);
		print_simpleMessage("new_user");
		printspacer(1);
		
		$actionframe="index.php?page=newutente";
		addline('<tr><th class="menu_2"><a class="menulink" href="'.$actionframe.'&choose=1">Compila il form</a></th>',$level);
	}
    printspacer(1);
    addline('<tr><th class="menu_2" align="center"><a class="link" href="index.php">ritorna al sito</a></td>',$level);
        
	addline('</td></table>',$level);
	addline('</table></td>',$level);
?>
