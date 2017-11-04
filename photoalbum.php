<?php


	session_start();
	
	$level = 0;
	$table="docs";
	$cols=5;
	$rows=20;
	$actionframe="index.php?page=photo";
    $direzione=$avanti.''.$indietro;
    
	if(!session_is_registered("extra_cartella_photo")){
		
		session_register("extra_cartella_photo");
		$extra_cartella_photo="";
	}
    

	$cartella_default = "-home-";
	
	if($cartella!=""){
	
		$extra_cartella_photo=" cartella='".$cartella."'";
	}else{
		if($direzione==""){
			$extra_cartella_photo=" cartella='".$cartella_default."'";			
			$cartella = $cartella_default;
		}
	}


	addline('<table class="centered" width="100%"  valign="top">',$level);
	addline('<tr> <th class="menu" colspan=2>PhotoAlbum</th>',$level);

	//printspacer(1);
	
	$classi=string2array(get_classiConsentite($utente)," ");

	$extra_classi=" where ".$extra_cartella_photo." and (classe='";
	$extra_classi2=" where ( classe='";
	
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


	$query_extra=$extra_classi." order by cartella asc";
	$query_extra_cartelle=$extra_classi2." group by cartella order by cartella asc";


	if($direzione!=""){
					
		if($avanti!=""){
			
			$tmp=string2array($avanti,"_");
			$from=$tmp[1];
			$to=$from+2*$cols;				
		}else{

			$tmp=string2array($indietro,"_");
			$to=$tmp[1];
			$from=$to-2*$cols;
		}
		$cartella=$tmp[0];
	}else{

		$from=0;
		$to=$from+2*$cols;
	}
	
    printspacer(1);
    
    addline('<tr><td valign=top align=left width=200>',$level);
    
	$opt=string2array("title+0+cols+1+category+".$cartella,"+");
	$campi_select="cartella";
    //echo $query_extra_cartelle;
	showdocfolders($table,$query_extra_cartelle,$campi_select,$actionframe,$opt);	
	
    addline('</td>',$level);
    
    addline('<td align=left valign=top>',$level);   
    
    $opt=string2array("title 0 rows ".$rows." cols ".$cols." from ".$from." to ".$to," ");
    $campi_select="file,commento";
    showdoc($table,$query_extra,$campi_select,$utente,$cartella,$actionframe,$opt);

    addline('</td></tr>',$level);
	addline('</table>',$level);
?>
