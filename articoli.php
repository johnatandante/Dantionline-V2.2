<?php

	session_start();

	$table="articoli";
	$id_alias="id";
	$query_extra=" order by data,id desc";
	$delimitatore=" ";
		
	// actionframe
	$actionframe="index.php?page=articoli";	
	$target="default";
	$cartella_default = "-home-";
    $direzione=$avanti.''.$indietro;

	// opzioni speciali
	$opt="";
	
	$slot = 5;
	$cols=1;	

	if($direzione!=""){
					
		if($avanti!=""){
			
			$tmp=string2array($avanti,"_");
			$from=$tmp[1];
			$to=$from+$slot;
		}else{

			$tmp=string2array($indietro,"_");
			$to=$tmp[1];
			$from=$to-$slot;
		}
		$cartella=$tmp[0];
	}else{

		$from=0;
		$to=$from+$slot;
	}


	if(!session_is_registered("extra_cartella_art")){
		
		session_register("extra_cartella_art");
		$extra_cartella_art="";
	}

	if($cartella!=""){
	
		$extra_cartella_art="cartella='".$cartella."' and ";
	}else{
		if($direzione==""){
			$extra_cartella_art="cartella='".$cartella_default."' and ";
            $cartella = $cartella_default;			
		}

	}

	addline('<TABLE class="centered" width="100%"  valign="top">',$level);
	addline('<tr> <th class="menu" colspan=2>Articoli</th>',$level);

	$livello=getPesoClasse($utente);
	$classi=string2array(get_classiConsentite($utente)," ");	

	$extra_classi=" where ".$extra_cartella_art." (classe='";
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

	$query_extra=$extra_classi.$query_extra;
	$query_extra_cartelle=$extra_classi2." group by cartella order by cartella";			
	
	printspacer(1);

    addline('<tr><td valign=top align= left width=150>',$level);
    
	$opt=string2array("title+0+cols+1+category+".$cartella,"+");
	$campi_select="cartella";
	showdocfolders($table,$query_extra_cartelle,$campi_select,$actionframe,$opt);

	//printspacer(1);
    addline('</td>',$level);
    addline('<td align=center valign=top>',$level);

	$opt=string2array("merch 0 title 0 extra 1 author 1 cols 1 rows ".$slot." from ".$from." to ".$to," ");
	#$add_on=$add_on." and cartella='".$cartella."'";		
	$campi_select="file,data,titolo,link,articolo,autore,extra";

	showdoc($table,$query_extra,$campi_select,$utente,$cartella,$actionframe,$opt);
	
    addline('</td></tr>',$level);
	addline('</table>',$level);
	
?>

