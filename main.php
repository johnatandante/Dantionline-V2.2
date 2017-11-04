<?php 
    if(!isset($actionframe))
        $actionframe = "";

	$max_rows=3;
	$table="news";
	$query_extra="order by id desc";		
	
	$level = 1;
	addline('<TABLE width="100%" class="centered" valign="top">',$level);
	addline('<TR>',++$level);
	addline('<th class=menu> Benvenuto in DantiOnLine ',$level);

	if($utente!="" && $utente!="anonymous"){
		echo $utente;
	}
	addline('</th>',$level--);

	printspacer(1);

	addline('<tr><td>',$level);
	addline('<table class="centered" width="80%" align="center">',++$level);
		printspacer(1);
		if($utente!="" && $utente!="anonymous"){
            $f = $foto;
			// carica immagine e presentazione
			$messaggio="Last logged in: ".$last_login;
		}else{
            $f = $foto_main;        
        }
		$file = file_exists("tn/".$f);
		if (!$file){
			$tn="";
		}else{
			$tn="tn/";
		}
        //echo ' - '.$foto_main;
		addline('<tr><td width="35%" class="centered"><img src="'.$tn.''.$f.'" height=100></td>',--$level);
		addline('<td class="left" valign="top">'.multiline($commento_utente).'</td>',$level);
		addline('<tr><td></td><td align="right">'.$messaggio.'</td>',$level);
		//addline('<tr><td></td><td align="right">'.$lora.'</td>',$level);

	addline('</table>',--$level);
	addline('</td>',--$level);

	printspacer(1);
	addline('<tr><td><TABLE align="center" class="centered" width="80%"  valign="top">',--$level);
	addline('<tr>',$level);
	addline('<th class="menu_2" colspan=2> News:</th>',++$level);
	addline('<tr><td></td><td width=800></td>',--$level);
	
	$campi_select=string2array("id data messaggio nome"," ");
	$campi_show=string2array("data messaggio"," ");
	$b_show=string2array(""," ");
	$opt=string2array("maxelements 5 messagelength 1000"," ");
	show4edit($table,$query_extra,$campi_select,$campi_show,$utente,
              $actionframe,$b_show,$opt);

	addline('</TABLE></td>',--$level);
	addline('</TABLE>',--$level);
?>