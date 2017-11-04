<?php

/*
	
	per la rappresentazione delle cartelle di immagini

*/

function showdocfolders($table,$query_extra,$camposelect,$actionframe,$opt){
	$level = 1;

	$cols=1;
	$i=0;
    $spacer = 0;
    $category = 0;
    $title = 0;
	
	$dir_image = "";

	if ($table == "docs"){
		$dir_image = "img/img_dir.gif";
	}else{
		$dir_image = "img/icon_dir.gif";	
	}

	while($opt[$i]!=""){
	
		switch($opt[$i]){
			
			case "cols":
				$cols=$opt[$i+1];
				break;

			case "category":
				$category=$opt[$i+1];
				break;
                
			case "spacer":
				$spacer=$opt[$i+1];
				break;
                
            case "title":
				$title=$opt[$i+1];
				break;    
		}
		$i=$i+2;
	}

	$conn=open_dbconnection("default");

	$sql='select '.$camposelect.' from '.$table.' '.$query_extra;
    
	$res=run_sql($sql,$conn);

	$row = mysqli_fetch_assoc($res);
	
	addline('<table align="centered" width="100%">',$level);
    if ($title==1){
        addline('<tr><th class="menu_2" colspan='.(2*$cols).' >...</th>',$level);
        
    }else{    
        addline('<tr><th colspan='.(2*$cols).' ></th>',$level);
        
    }
    //printspacer(1);
	
	addline('<tr>',$level);
	$i=0;
	
	while($row[0]!=""){
        $special_folder=string2array("blog io goodlinks downloads canzoni bio links merchandise"," ");
        $lowerstring = strtolower($row[0]);
        if (!ismemberof($lowerstring,$special_folder)){
            //echo "$category != $row[0]";
            if ($category != $row[0]){
                addline('<td class="centered" width=50><a class="fotolink" href="'.$actionframe.'&cartella='.$row[0].'"><img height=35  src="'.$dir_image.'"></a></td>',$level);
                addline('<td class="left" width=75><a class="link" href="'.$actionframe.'&cartella='.$row[0].'">'.$row[0].'</a></td>',$level);
            }else{
                addline('<td class="centered" width=50><img height=35 src="'.$dir_image.'"></a></td><td class="left" width=75>&gt; '.ucfirst($row[0]).'</td>',$level);	
            }
        }else{
            // do nothing (cartella non visualizzabile)
            $i--;
        }

		$i=$i+1;
		if($i==$cols){
			$i=0;
			addline('<tr>',$level);
		}
		$row = mysqli_fetch_assoc($res);
	}
	close_dbconnection($conn);
    
   
    while($i!=$cols){
        addline('<td width=20 /><td width=80 />',$level);
        $i++;
    
    }
    
	addline('</table>',$level);
    
}

/*
	
	per gestione e la rappresentazione delle immagini ed articoli in generale

*/

function showdoc($table,$query_extra,$campi_select,$utente,$cartella,$actionframe,$opt){
	$level = 1;
	$cols=1;
	$rows=1;
	$from=0;
	$to=$from+$cols;
	$tot_tuple=contatuple($table,"id",$query_extra);
    
	$extra = 0;
    $merch = 0;
    $category = 0;
    $spacer = 0;
    $title = 0;
    $author = 0;
    $icon = "";

	$i=0;
	while($opt[$i]!=""){
	
		switch($opt[$i]){			
			case "cols":
				$cols=$opt[$i+1];
				break;
			case "rows":
				$rows=$opt[$i+1];
				break;
			case "from":
				$from=$opt[$i+1];
				break;
			case "extra":
				$extra=$opt[$i+1];
				break;
            case "merch":
				$merch=$opt[$i+1];
				break;
			case "category":
				$category=$opt[$i+1];
				break;                
			case "spacer":
				$spacer=$opt[$i+1];
				break;
            case "title":
				$title=$opt[$i+1];
				break;
            case "author":
				$author=$opt[$i+1];
				break;
		}
		$i=$i+2;
	}

	$to=$from+$rows*$cols;	

	$conn=open_dbconnection("default");
	$sql='select '.$campi_select.' from '.$table.' '.$query_extra;
    
	$res=run_sql($sql,$conn);

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
	
	if($cartella!=""){

        if ($table=="docs"){
            
            addline('<table class="centered" >',$level);
        }else{
            addline('<table class="centered" width=100%>',$level);
        }
		
		if($title==1){
			addline('<tr><th class="menu_2" colspan=10> Categoria: '.$cartella.'</th>',$level);
		}
		
		addline('<tr>',$level);
		$i=0;
		$elements=0;
		while(($row[0]!="" || $row[4]!="") && ($elements+$from)<$to){
            $img_width = 80;
            
			$elements=$elements+1;
			$i=$i+1;

            if (isimage($row[0])){
                $icon = "icon_img.gif";

            }else if (ismp3($row[0])){
                $icon = "icon_mp3.gif";

            }else if (isarchive($row[0])){
                $icon = "icon_zip.gif";

            }else if (isfile($row[0])){
                $icon = "icon_file.gif";

            }else if (ispdf($row[0])){
                $icon = "icon_pdf.gif";

            }else if (isvideo($link)){
                $icon = "icon_video.gif";

            }else{
                $icon = "icon_unknow.gif";
            }

			
			if($row[0]!=""){
								
                $file = file_exists($row[0]);                
                
                $tn_file = file_exists("tn/".$row[0]);                
                if (!$file && !$tn_file){						
                    $icona='<img src="img/icon_noimg.gif" width=80>';
                }elseif (!$file && $tn_file){
                    
                    $icona='<img src="tn/'.$row[0].'" height='.$img_width.' width='.$img_width.'>';
                }else{
                    
                    $href='href="'.$row[0].'"';
                    
                    if (!$tn_file && !isimage($row[0])){
                        $tn="img/".$icon;
                    }else{
                                                
                        if ($tn_file){
                            $tn="tn/".$row[0];
                        }else{
                            $tn=$row[0];
                        }
                        
                    }
                    
                    $icona='<a class="link" '.$href.' target="'.$row[0].'"><img src="'.$tn.'" height='.$img_width.' width='.$img_width.'></a>';
                    
                }
				
			}else{
				
				$icona="";
			}

			if ($table=="docs"){
				
				// modalità file singoli
				if($row[1]==""){
					// row[1] è il commento dell'immagine
					$row[1]="---";
				}

				//addline('<td align=center>'.$icona.'<br><p class=centered>['.$row[1].']</p ></td>',$level);
                addline('<td align=center>'.$icona.'</td>',$level);
				
				if($i==$cols){
					$i=0;
					addline('<tr >',$level);
				}

			}else if($table=="articoli"){
				
				// modalità articoli
				$titolo_articolo=$row[2];
				$testo_articolo=$row[4];
				$link_articolo=getRigthUrl($row[3]);
				$data_articolo=getMyData($row[1]);
				$autore_articolo=$row[5];
                $extra_articolo=$row[6];

                if($titolo_articolo == ""){
                    $titolo_articolo = "...";
                }
                
				// modalità articoli
				addline('<tr><td><table class="centered" width="100%" align="center">',$level);

                if ($merch != 1){
                    addline('<tr><th class="menu_3" colspan=2> '.$titolo_articolo.' </th>',$level);

                }

				if($i%2==1 || $merch == 1){
					// file a sx e testo a dx
					addline('<tr><td valign="top" align=center>'.$icona.'</td>',$level);
                    if ($merch == 1){
					    addline('<td width=75% align="left" valign="top"><strong>Articolo:</strong> '.$titolo_articolo,$level);
					    addline('<br><strong>Descrizione:</strong> '.richtext($testo_articolo),$level);
                        addline('<br><br><strong>Prezzo:</strong> '.$extra_articolo,$level);

                    }else{
					    addline('<td width=75% align="left" valign="top">'.richtext($testo_articolo),$level);                                      
                        if($extra==1 && $extra_articolo!=""){
                            addline('<br><br>['.richtext($extra_articolo).']</td>',$level);
                        }else{
                            addline('</td>',$level);
                        }
                    }

				}else{
					// file a dx e testo a sx
					addline('<tr><td width=75% align="left" valign="top">'.richtext($testo_articolo),$level);
                    if($extra==1 && $extra_articolo!=""){
                        addline('<br><br>['.richtext($extra_articolo).']</td>',$level);
                    }else{
                        addline('</td>',$level);
                    }
					addline('<td align=center valign="top">'.$icona.'</td>',$level);
				}

                
                
				if($link_articolo!=""){
					addline('<tr><td align="left" colspan=2>Related documents at: <a class="link" href="'.$link_articolo.'" target="'.$link_articolo.'">'.$link_articolo.'</a></td>',$level);
				}
                
                if($merch != 1){
	  			    addline('<tr><td align="right" colspan=2>  [Added on: '.$data_articolo.'] </td>',$level);
                }				
                
                if($author==1){
					addline('<tr><td align="right" colspan=2> [Autore: <strong>'.$autore_articolo.'</strong>]</td>',$level);
				}
                
                if ($spacer !=0){
                    printspacer($spacer);
                }
				addline('</table></td>',$level);
			}
			
			$row = mysqli_fetch_assoc($res);
		}
        
        while((($elements+$from)<$to) && $i!=$cols && $table=="docs"){
            addline('<td height=100 width='.$img_width.' ></td>',$level);
            $i++;
        }
        
		addline('<tr>',$level);
		if($from-1>0){
		
			addline('<th align="left"><a class="menulink" href="'.$actionframe.'&indietro='.$cartella.'_'.($from).'" >Prev</th>',$level);
		}else{

			addline('<th />',$level);
		}

		if($to<$tot_tuple){
			addline('<th colspan='.($cols-2).' />',$level);
			$fromto="from ".($to+1)." to ".($to+($to-$from));
			addline('<th align="right"><a class="menulink" href="'.$actionframe.'&avanti='.$cartella.'_'.($to).'" >Next</th>',$level);
		}else{

			addline('<th />',$level);
		}        
        

    
		addline('</table>',$level);

	}
	close_dbconnection($conn);
    
}

/*
	
	uso improprio della tabella "articoli" per la gestione dei downloads

*/

function showdownloads($table,$query_extra,$campi_select,$utente,$cartella,$actionframe,$opt){
	$level = 1;
	$cols=1;
	$rows=1;
	$from=0;
	$to=$from+$cols;
	$tot_tuple=contatuple($table,"id",$query_extra);
	$extra=0;
    $author=0;

	$i=0;
	while($opt[$i]!=""){
	
		switch($opt[$i]){			
			case "cols":
				$cols=$opt[$i+1];
				break;
			case "rows":
				$rows=$opt[$i+1];
				break;
			case "from":
				$from=$opt[$i+1];
				break;
			case "extra":
				$extra=$opt[$i+1];
				break;
            case "author":
				$author=$opt[$i+1];
				break;                
		}
		$i=$i+2;
	}

	$to=$from+$rows*$cols;	

	$conn=open_dbconnection("default");
	$sql='select '.$campi_select.' from '.$table.' '.$query_extra;
    //echo ''.$sql;
	$res=run_sql($sql,$conn);

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
	
	if($cartella!=""){
        
		addline('<tr><td align="center">',$level);
		addline('<table class="centered" width="95%">',$level);
		
		if($extra!=0){
			addline('<tr><th class="menu_2" colspan=10>'.$cartella.'</th>',$level);
		}
		
		addline('<tr>',$level);
		$i=0;
		$elements=0;
        
        $last_category  = "nocategory";
        
		while(($row[0]!="" || $row[3]!="") && ($elements+$from)<$to){
            //echo "row[0]: ".$row[0]." row[3]: ".$row[3]." elements+from: ".($elements+$from)." to: ".$to;
			$elements=$elements+1;
			$i=$i+1;
			
            // modalità articoli
            // $campi_select="data,titolo,link,articolo";
            
            $categoria=$row[1];
            $testo=$row[3];
            $link=getRigthUrl($row[2]);
            
            if (isimage($link)){
                $icon = "icon_img.gif";

            }else if (ismp3($link)){
                $icon = "icon_mp3.gif";

            }else if (isarchive($link)){
                $icon = "icon_zip.gif";

            }else if (isfile($link)){
                $icon = "icon_file.gif";

            }else if (ispdf($link)){
                $icon = "icon_pdf.gif";

            }else if (isvideo($link)){
                $icon = "icon_video.gif";

            }else{
                $icon = "icon_unknow.gif";
            }

            $data=$row[0];
            // non occorre mettere 
            $autore=$row[4]; 

            // modalità articoli

            addline('<tr><td><table class="centered" width="95%" align="center">',$level);
            if ($categoria != $last_category){
                addline('<tr><th class="menu_3" colspan=3>'.$categoria.'</th>',$level);
                $last_category = $categoria;
            }
            
            addline('<tr>',$level);
            addline('<td class="centered" width = 100><img src="img/'.$icon.'"></td>',$level);

            if($link!=""){
                $strong1 = '<strong>';
                $strong2 = '</strong>';
            }else{
                $strong1 = '';
                $strong2 = '';
            }
            addline('<td class="left" valign="top">',$level);
            addline($testo,$level);
            addline('<br>[Added on: '.$data.']', $level);

            if($author!=0){                
                addline('<br>[Autore: <strong>'.$autore.'</strong>]',$level);
            }
            
            addline('</td>',$level);
            addline('<td class="right" valign="top" width=100>',$level);
            
            if($link!=""){
                addline('<a class="link" href="'.$link.'" target="'.$link.'">',$level);
            }
                        
            addline('[ Scarica ]',$level);

            if($link!=""){
                addline('</a></td>',$level);
            }
            addline('</table></td>',$level);
		
			$row = mysqli_fetch_assoc($res);
            //echo "row[0]: ".$row[0]." row[3]: ".$row[3]." elements+from: ".($elements+$from)." to: ".$to;
		}
        
        
		addline('<tr>',$level);
		if($from-1>0){
		
			addline('<th align="left"><a class="menulink" href="'.$actionframe.'&indietro='.$cartella.'_'.($from).'" >Prev</th>',$level);
		}else{

			addline('<th />',$level);
		}

		if($to<$tot_tuple){
			addline('<th colspan='.($cols-2).' />',$level);
			$fromto="from ".($to+1)." to ".($to+($to-$from));
			addline('<th align="right"><a class="menulink" href="'.$actionframe.'&avanti='.$cartella.'_'.($to).'" >Next</th>',$level);
		}else{

			addline('<th />',$level);
		}
        
		addline('</table>',$level);

	}
	close_dbconnection($conn);	
}


/*

	controlla se il file ha nome come immagine

*/
function isimage($file){
	
	$bool=0;	
	$ext=strtolower(getextension($file));
	$img_ext=string2array(".jpg .gif .gif .bmp .png"," ");
	return ismemberof($ext,$img_ext);
}


/*

	controlla se il file ha nome come mp3

*/
function ismp3($file){
	
	$bool=0;	
	$ext=strtolower(getextension($file));
	$img_ext=string2array(".mp3 .wav .ogg"," ");
	return ismemberof($ext,$img_ext);
}

/*

	controlla se il file ha nome come avi

*/
function isvideo($file){
	
	$bool=0;	
	$ext=strtolower(getextension($file));
	$img_ext=string2array(".mpg .avi .wmv"," ");
	return ismemberof($ext,$img_ext);
}

/*

	controlla se il file ha nome come archivio

*/
function isarchive($file){
	
	$bool=0;	
	$ext=strtolower(getextension($file));
	$img_ext=string2array(".zip .gz .tar .rar"," ");
	return ismemberof($ext,$img_ext);
}

/*

	controlla se il file ha nome come documento di testo

*/
function isfile($file){
	
	$bool=0;	
	$ext=strtolower(getextension($file));
	$img_ext=string2array(".txt .doc .odt .html .htm .php"," ");
	return ismemberof($ext,$img_ext);
}
    
/*

	controlla se il file ha nome come documento pdf

*/
function ispdf($file){
	
	$bool=0;	
	$ext=strtolower(getextension($file));
	$img_ext=string2array(".pdf "," ");
	return ismemberof($ext,$img_ext);
}
?>