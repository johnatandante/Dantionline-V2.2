<?php

/*
	
	visualizza una una tupla di dati in verticale, con possibilità di aggiungere bottoni
	tipo "delete" o altro

*/

function showrow($table,$id,$campi,$hide,$user,$button_show,$actionframe,$target){
	$level = 1;
	$query_extra="";
	//$target = 'target="user_main"';

	$nomecampi=string2array($campi[0].''," ");
	$valorecampi=string2array($id,"+");
	
	$row = select($table,$campi,$nomecampi,$valorecampi,$query_extra);
		
	$j=0;
	while($j<sizeof($campi)){

		if(ismemberof($campi[$j],$hide)!=1){

			switch($campi[$j]){

				case "data":
					$row[$j]= getMyData($row[$j]);
					break;
                case "last_login":
					$row[$j]= getMyData($row[$j]);
					break;                    

				case "mail":
					$row[$j]='<a class="link" href="mailto:'.$row[$j].'">'.$row[$j].'</a>';
					break;
				
				case "foto":
					$row[$j]='<a class="link" href="'.$row[$j].'" target="'.$row[$j].'">'.$row[$j].'</a>';
					break;
				
				case "file":
					$row[$j]='<a class="link" href="'.$row[$j].'" target="'.$row[$j].'">'.$row[$j].'</a>';
					break;

				case "link":
					$row[$j]='<a class="link" href="'.getRigthUrl($row[$j]).'" target="'.$row[$j].'">'.$row[$j].'</a>';
					break;
				
				case "articolo":
					$row[$j]=richtext($row[$j]);
					break;

				case "messaggio":
					$row[$j]=richtext($row[$j]);
					break;

				case "commento":
					$row[$j]=richtext($row[$j]);
					break;					

				case "descrizione":
					$row[$j]=richtext($row[$j]);
					break;	

				case "sitoweb":
					$row[$j]='<a class="link" href="'.getRigthUrl($row[$j]).'" target="'.$row[$j].'">'.$row[$j].'</a>';
					$campi[$j]="sito web";
					break;
			}

			addline('<tr><td class="etichetta">'.$campi[$j],'</td>',$level);
			addline('<td align="left">'.$row[$j].'</td>',$level);
		}
		$j=$j+1;
	}
	
	addline('<tr><td align="center" colspan=2>',$level);
	addline('<table width="100%"><tr>',$level);
	addline('<form action="'.$actionframe.'" '.$target.' method="post">',$level);

	
	$id_alias = "id";
	if ($table == "classi"){
		$id_alias = "nomeclasse";		
	}

	addline('<input type="hidden" name="'.$id_alias.'" value="'.$id.'">',$level);

	if(ismemberof("InviaMessaggio",$button_show)==1){
		if ($table=="mail"){
			$id = $row[2];
		}

		addline('<input type="hidden" name="nome" value="'.$id.'">',$level);

		addline('<tr class="menu_2"><td  colspan=2></td>',$level);
		addline('<tr><td class="etichetta">Testo <br>Messaggio</td>',$level);
		addline('<td><textarea name="sms" cols=60 rows=5></textarea>',$level);
		addline('<tr><td class="centered" colspan=2><input type="submit" name="invia" value="invia"></td>',$level);
	}

	if(isadmin($user)==1){
		
		addline('<input type="hidden" name="to" value="'.$row[0].'">',$level);
		$k=0;
		while($button_show[$k]!=""){
			
			if($button_show[$k]=="reset"){
				
				addline('<td align="center"><input type="reset" name="reset" value="reset"></td>',$level);
			}else if($button_show[$k]!="" && $button_show[$k]!="InviaMessaggio"){

				addline('<td align="center"><input type="submit" name="'.$button_show[$k].'" value="'.$button_show[$k].'"></td>',$level);
			}
			$k=$k+1;
		}		
		
	}
	addline('</form>',$level);
	addline('</table></td>',$level);
}

/*
	
	funzione che rappresenta una lista di tuple da una tabella del database in orrizzontale

*/

function show4edit($table,$query_extra,$campi_select,$campi_show,$user,$actionframe,$b_show,$opt){
	$level = 1;
	$messagelength=1000;
	$maxelements=10000;
	$AddedBy=0;
	$from=0;
	$to=$maxelements;	
	$tot_tuple=contatuple($table,$campi_select[0],$query_extra);
	$id_alias=$campi_select[0];
	$id_alias_name = $id_alias;
	$nuovo=0;

	if($opt!=""){
		
		$i=0;
		while(isset($opt[$i]) && $opt[$i]!=""){
		
			switch($opt[$i]){
				
				case "maxelements":
					$maxelements=$opt[$i+1];
					break;
				case "messagelength":
					$messagelength=$opt[$i+1];
					break;
				case "AddedBy":
					$AddedBy=1;
					$i=$i-1;
					break;
				case "from";
					$from=$opt[$i+1];
					break;
				case "to";
					$to=$opt[$i+1];
					break;
				case "id_alias":
					$id_alias=$opt[$i+1];
					break;
				case "id_index":
					$id_index=$opt[$i+1];
					break;
				case "nuovo":
					$nuovo=1;
					$i=$i-1;
					break;
			}
			$i=$i+2;
		}
				
	}

	printmenu($campi_show,$b_show,$opt);

	$conn=open_dbconnection("default");
	
	$campi=$campi_select[0];
	$i=1;
	while(isset($campi_select[$i]) && $campi_select[$i]!=""){
		
		$campi=$campi.",".$campi_select[$i];
		$i=$i+1;
	}

	$sql="select ".$campi." from ".$table." ".$query_extra;
	//echo "<br>SQL -> ".$sql;
	$res=run_sql($sql,$conn);
	
	if($campi_select[0]=="*"){

		$campi_select=$campi_show;
	}

	// cerco l'indice del campo "nome"
	$user_index=0;
	while(($campi_select[$user_index]!="nome" && $campi_select[$user_index]!="autore") && $user_index<sizeof($campi_select)){
		
		$user_index=$user_index+1;
	}
	
	if($tot_tuple<=$from || $from==""){
	
		$n_rows=$to-$from;
		$from=$from-$n_rows;
		if($from<0){
		
			$from=0;
		}
		
		$to=$from+$n_rows;
	}
	
	if($tot_tuple>$from){

		mysqli_data_seek ($res, $from);
	}

	$row = mysqli_fetch_assoc($res);

	$elements=0;
	while(isset($row[0]) && $row[0]!="" && $maxelements>$elements && ($elements+$from)<$to){
		
		$elements=$elements+1;
		
		if($nuovo==1 && $row[5]=="sì"){
			$strong1="<strong>";
			$strong2="</strong>";
		}else{
			$strong1="";
			$strong2="";
		}


		addline('<tr>',$level);

		$j=0;
		$i=0;
		while($i<sizeof($campi_show)){

			if($campi_show[$i]==$campi_select[$j] ){
				if ($row[$j] == "" && ($campi_show[$i]=="file" || $campi_show[$i]=="foto")){
					$row[$j] = "img/default.gif";
				}


				if($campi_show[$i]=="file" || $campi_show[$i]=="foto"){
					$file = file_exists("tn/".$row[$j]);
					if (!$file){
						$tn="";
					}else{
						$tn="tn/";
					}

					$file = file_exists($row[$j]);
					if (!$file){
						$row[$j]="img/icon_noimg.gif";
                        $tn="";
						addline('<td class="centered" valign="top"><img src="'.$tn.''.$row[$j].'" height=35></td>',$level);
					}else{

						addline('<td class="centered" valign="top"><a class="link" href="'.$row[$j].'" target="'.$row[$j].'"><img src="'.$tn.''.$row[$j].'" height=50></a></td>',$level);
					}
				}else if($campi_show[$i]=="last_login" || $campi_show[$i]=="data"){
					
					if($row[$j] != 0 && $row[$j] != ""){
						$data = getMyData($row[$j]);
					}else{
						$data = "---";
					}

					addline('<td class="centered" valign="top" width=95>'.$strong1.$data.$strong2.'</td>',$level);
				}else{
                    if ($messagelength > 0){
                        addline('<td class="left" valign="top" >'.$strong1.preview(richtext($row[$j]),$messagelength).$strong2.' </td>',$level);
                    }else{
                        addline('<td class="left" valign="top" >'.$strong1.richtext($row[$j]).$strong2.' </td>',$level);
                    }
				}
				$i=$i+1;
			}
			$j=$j+1;
		}
		
		if($AddedBy==1){
			addline('<td class="left" valign="top" >'.$strong1.$row[$user_index].$strong2.'</td>',$level);
		}
		

		//addline('<form action="'.$actionframe.'" method="post" target="user_main">';
		addline('<form action="'.$actionframe.'" method="post">',$level);

			
		// controllo sul campo $id_alias
				
		//echo "<br>$id_alias==$campi_select[0] -> ".$id_alias."==".$campi_select[0];
		if($id_alias==$campi_select[0]){
			$id=$row[0];				
		}else{
			
			$id=$row[$id_index];			
		}

		if($table == "classi"){
			
			$id_alias_name = "nomeclasse";
		}
		
		addline('<input type="hidden" name="'.$id_alias_name.'" value="'.$id.'">',$level);

		
		$k=0;
		while($b_show[$k]!=""){
			
			if($b_show[$k]=="mostra" || canEdit($user,$row[$user_index]) || $table=="mail"){
				
				// qua andranno i bottoni di lettura come "mostra"
				// e se l'utente ha il diritto anche "edit" e "delete"
				addline('<td class="right" width=50><input type="submit" name="'.$b_show[$k].'" value="'.$b_show[$k].'"></td>',$level);
			}
			
			$k=$k+1;
		}
			

		addline('<input type="hidden" name="inizio" value="'.$from.'">',$level);
		addline('</form>',$level);
		
		$row = mysqli_fetch_assoc($res);
	}	
	
	addline('<tr><td colspan='.(sizeof($campi_show)+sizeof($b_show)+sizeof($AddedBy)).'><table width="100%">',$level);

	addline('<tr>',$level);
	if($from-1>0){
	
		//addline('<td align="left"><a class="menulink" href="'.$actionframe.'&indietro='.($from).'" target="user_main">Prev</td>';
		addline('<td align="left"><a class="menulink" href="'.$actionframe.'&indietro='.($from).'">Prev</td>',$level);
	}else{

		addline('<td ></th>',$level);
	}

	if($to<$tot_tuple){
		
		$fromto="from ".($to+1)." to ".($to+($to-$from));
		//addline('<th align="right"><a class="menulink" href="'.$actionframe.'&avanti='.($to).'" target="user_main">Next</th>';
		addline('<th align="right"><a class="menulink" href="'.$actionframe.'&avanti='.($to).'">Next</th>',$level);
	}else{

		addline('<th ></th>',$level);
	}
	addline('</table></td>',$level);

	//close_dbconnection($conn);
}

/*

	funzione quasi inutile che ha il compito di stampare il menù di una tabella
	per la rappresentazione verticale (chiamata da show4edit)

*/

function printmenu($campi,$butt,$opt){
	$level = 1;
	addline('<tr >',$level);
	
	$i=0;
	while( isset($campi[$i]) && $campi[$i]!=""){
		
		if($campi[$i]=="data"){
			$width=95;
		}
		addline('<th class="menu_2" width='.$width.'>'.$campi[$i].'</th>',$level);
		$i=$i+1;
	}
	
	if($opt!=""){
		
		$i=0;
		while(isset($opt[$i]) && $opt[$i]!=""){
		
			switch($opt[$i]){
				case "AddedBy":
					addline('<th class="menu_2" width=100>AddedBy</th>',$level);
					break;				
			}
			$i=$i+2;
		}
				
	}

	$i=0;
	while( isset($butt[$i]) && $butt[$i]!=""){
		
		$i=$i+1;
		addline('<th class="menu_2"></th>',$level);
	}

}

/*
	
	funzione che implementa un form in base a tot campi dati in input
	
*/

function form($table,$nome_campi,$valore_campi,$hide,$actionframe,$target,$mode,$user){

	if($target=="" || $target=="default"){		
		//$target='target="user_main"';
		$target="";
	}

	// need id calcolato???
	// l'indice è sempre nella prima posizione
	if(ismemberof("id",$hide) && $mode!="edit"){
		
		$query_adds="default";
		$valore_campi[0]=find_nextIndex($table);
	}

	addline('<form action="'.$actionframe.'" method="post" enctype="multipart/form-data">',$level);
	
	$i=0;
	$i_hide=0;
	while($nome_campi[$i]!=""){

		if($nome_campi[$i]==$hide[$i_hide]){

			addline('<input type="hidden" name="campo['.$i.']" value="'.$valore_campi[$i].'">',$level);
			$i_hide=$i_hide+1;

		}else {			
			
			addline('<tr><td class="etichetta">'.$nome_campi[$i].'</td>',$level);
			
			if(($nome_campi[$i]=="canzoni"  && $table=="music") || $nome_campi[$i]=="messaggio" || $nome_campi[$i]=="commento" || $nome_campi[$i]=="descrizione" || $nome_campi[$i]=="articolo"){
				$maxlength=2048;
                if ($table=="docs" || $table=="downloads"){
                    // non serve una textarea
                    addline('<td class="left"><input type="text" name="campo['.$i.']" size=35 value="'.$valore_campi[$i].'" /></td>',$level);
                }else{
                    // serve una textarea
                    addline('<td class="left"><textarea name="campo['.$i.']" cols=60 rows=6 wrap="phisical" maxlength="'.$maxlength.'">'.$valore_campi[$i].'</textarea></td>',$level);
                }
			}else if($nome_campi[$i]=="password"){
				
				$maxlength=63;
				// campo password
				addline('<td class="left"><input type="password" name="campo['.$i.']" value="'.wordwrap( $valore_campi[$i], 50, "\n", 1).'" size="25" maxlength="'.$maxlength.'"></td>',$level);
			}else if($nome_campi[$i]=="file" || ($nome_campi[$i]=="file" && $table=="downloads")){

				// campo file
				//addline('<td class="left"><input type="text" name="file" value="'.$valore_campi[$i].'">';

				// campo file
				addline('<td class="left">',$level);
                if ($table!="docs" || $mode=="add"){
                    addline('<input type="file" name="file" size="20"><br>',$level);    				
                }
				addline('<input type="text" name="campo['.$i.']" value="'.$valore_campi[$i].'"></td>',$level);
			}else if(($nome_campi[$i]=="classe" && $table!="classi") || $nome_campi[$i]=="destinatario" || ($nome_campi[$i]=="cartella" && $mode=="add")){
				
				if($nome_campi[$i]=="destinatario"){
					$select=string2array(get_lista($nome_campi[$i]),"+");
                    
				}else if($nome_campi[$i]=="cartella"){
                    $select=string2array(get_listaCartelle($table,$valore_campi[$i]),"+");
                    
                }else{					
					$select=string2array(get_classiUtente($valore_campi[$i])," ");                    
				}
				// campo classe
				addline('<td class="left">',$level);
				addline('<select name="campo['.$i.']">',$level);
				
				$j=0;
				while($select[$j]!=""){
					addline('<option value="'.$select[$j].'">'.$select[$j],$level);
					$j=$j+1;
				}
				addline('</select></td>',$level);

			}else if(($nome_campi[$i]=="genere" || $nome_campi[$i]=="supporto") && $table=="music"){
				
				$select=string2array(get_lista($nome_campi[$i]),"+");				
				
				// campo classe
				addline('<td class="left">',$level);
				addline('<select name="campo['.$i.']">',$level++);
				
				$j=0;
				while($select[$j]!=""){
					addline('<option value="'.$select[$j].'">'.$select[$j],$level);
					$j=$j+1;
				}
				addline('</select></td>',--$level);

			}else{
				if($nome_campi[$i]=="nome" || $nome_campi[$i]=="visitatore"){
					
					$maxlength=15;
				}else{
				
					$maxlength=127;
				}
                
                if ($nome_campi[$i]=="anno"){
                    $maxlength=4;
                }
                
                
				// basta uan textbox
				addline('<td class="left"><input type="text" name="campo['.$i.']" maxlength="'.$maxlength.'" value="'.wordwrap( $valore_campi[$i], 50, "\n", 1).'" size="25"></td>',$level);
			}
		}
		$i=$i+1;
	}

	if($mode=="edit"){
		// edit mode
		addline('<tr><td class="centered"><input type="reset" name="reset" value="reset"></td>',$level);	
		addline('<td class="centered"><input type="submit" name="update" value="update"></td>',$level);
	}
	
	if($mode=="add"){
		// add mode
		addline('<tr><td class="centered" colspan=2><input type="submit" name="inserisci" value="inserisci"></td>',$level);
	}
	addline('</form>',$level);
}


/*
	
	per l'editing dei campi di una tupla

*/

function editrow($table,$id,$campi_select,$hide,$button_show,$actionframe,$target,$user){

	$nomecampi=string2array($campi_select[0]," ");
	$valorecampi=string2array($id,"+");
	$row=select($table,$campi_select,$nomecampi,$valorecampi,$query_extra);
	
	form($table,$campi_select,$row,$hide,$actionframe,$target,"edit",$user);
}



?>