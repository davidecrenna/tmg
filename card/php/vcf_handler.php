<?php
require_once("../../headerbasic.php");
require_once "../../header.php";
?>
	<script language="javascript" type="text/javascript">
        window.parent.document.getElementById("mailing_loading").style.display = "block";
    </script>
<?php
define("MAXPARSING",15000);
define("REQUIRED_PROPERTIES","EMAIL");
define("SHOW_DEBUG",false);

    $uploader=new PhpUploader();    
   	$username=$_GET['u'];
	
	$card= new Card(NULL,$username);
	
	$mvcfile=$uploader->GetValidatingFile();
	if($card->Is_uploadable($mvcfile->FilePath)==1){
		$uploader->WriteValidationError("Non è possibile eseguire l'upload, l'utente ha terminato lo spazio residuo della card.");
	}
	
	if(!$card->is_user_logged()){
		$uploader->WriteValidationError("Devi essere loggato!");
		exit(200);
	}
	
	//$card->del_file_in_dir("../../".USERS_PATH.$card->username."/download_area/evidenza/news_".$news_id);
    
	
    //USER CODE:
	$file_name = str_replace("'","",$mvcfile->FileName);
	$file_name = str_replace(" ","_",$file_name);
    $targetfilepath = "../../tmp_vcf/".$file_name;
	
    if( is_file ($targetfilepath) )    
     	unlink($targetfilepath);    
    $mvcfile->MoveTo($targetfilepath);    
    $uploader->WriteValidationOK();
	
	$results_text = print_vcard_address_book("../../tmp_vcf/".$file_name,$card);

function print_vcard_address_book($file,$usercard)
{
	
	//se non trovo il file
    if (!$file) {
        exit('Required $file parameter not specified.');
    }
	
	//assegno a lines il file
    $lines = file($file);
	
	//non è stato possibile eseguire il parsing del file
    if (!$lines) {
        exit("Can't read the vCard file: $file");
    }
	
	
	$lines = file($file);
	
	//array di proprietà necessarie all'analisi della card
	$required_properties = array(REQUIRED_PROPERTIES);
	
	$start =0;
	//contatore totale di vcard analizzate
	$total_parsed=0;
	//contatore dei cicli
	$ciclo =0;
	
	//variabile di controllo errori di importazione
	$errors=false;
	
	//variabile di controllo cards non importate
	$skipped_cards=false;
	
	//variabile di controllo del ciclo
	$stop=false;
	while($stop==false){
		//contatore di vcard analizzate
		$count_parsed = 0;
		/* 
		METHOD parse_vacrds() --> eseguo il parsing del file vcf
		* $lines file .vcf in input
		* $start numero di vcard analizzate di partenza
		* $count_parsed contatore vcard analizzate
		* $errors variabile di controllo errori di analisi vcards
		* $required_properties array contenente variabili necessarie all'analisi
		* $skipped variabile di controllo vcards non importate perchè non contengono required_properties 
		*/
		$cards = parse_vcards($lines,$start,$count_parsed,&$errors,$required_properties,&$skipped);
		
		//salvo le vcard
		store_vcards($cards,$usercard);
		
		$total_parsed = $total_parsed + $count_parsed;
		
		/*echo "<br/>ciclo numero ".$ciclo.": <br/>";
		echo "start= ".$start."<br/>";
		echo "count_parsed= ".$count_parsed."<br/>";
		echo "total_parsed= ".$total_parsed."<br/>";*/
		
		if($count_parsed==MAXPARSING){
			$start = $start + MAXPARSING;
			$count_parsed=0;
		}else{
			$stop = true;	
		}
		$ciclo++;
	}
	$results_text="";
	//se non sono stati importati contatti privi di proprietà nell'array skipped
	if($skipped){
		$results_text.= "Alcuni contatti non sono stati importati poichè non contengono l'indirizzo email.";	
	}
	
	//se ci sono stati errori nell'importazione di contatti
	if($errors){
		$results_text.=  " Errore nell'importazione della rubrica ".pathinfo($file,PATHINFO_BASENAME).", alcuni indirizzi potrebbero non essere stati importati. ";	
	}
	
	$results_text.= "Totale contatti importati: ".$total_parsed;
	return $results_text;
}
/* 
	METHOD parse_vacrds() --> eseguo il parsing del file vcf
	* &$lines file .vcf in input
	* $start numero di vcard analizzate di partenza
	* &$count_parsed contatore vcard analizzate
	* &$errors variabile di controllo errori di analisi vcards
	* $skip_properties array contenente variabili da saltare
	* &$skipped variabile di controllo vcards non importate 
*/
function parse_vcards(&$lines,$start,&$count_parsed,&$errors,$skip_properties,&$skipped)
{
	
    $cards = array();
    $card = new VCard();
	
	while($card->parse($lines)&&$i<MAXPARSING){
		//variabile di controllo proprietà da non analizzare
		$skip = false;
		
		if(count($skip_properties)>0)
			foreach($skip_properties as $name){
				$ctrl =$card->getProperty($name); 
				if(!$ctrl){
					$skip = true;
				}
			}
			
		//se la vcard non contiene il nome
		$property = $card->getProperty('N');
		
		
		if (!$property) {
			$errors=true;
		}else if($skip == true){
			$skipped = true;
		}else{
			$n = $property->getComponents();
			$tmp = array();
			if ($n[3]) 
				$tmp[] = $n[3];      // Mr.
			if ($n[1]) 
				$tmp[] = $n[1];      // John
			if ($n[2]) 
				$tmp[] = $n[2];      // Quinlan
			if ($n[4]) 
				$tmp[] = $n[4];      // Esq.
			
			$ret = array();
			if ($n[0]) 
				$ret[] = $n[0];
			
			$tmp = join(" ", $tmp);
			if ($tmp) 
				$ret[] = $tmp;
			
			$key = join(", ", $ret);
			$cards[$key] = $card;
			$count_parsed++;
		}
		// MDH: Create new VCard to prevent overwriting previous one (PHP5)
		$card = new VCard();
	}
	
    return $cards;
}

function store_vcards(&$cards,$usercard){
	//processo tutte le categorie
    $categories_to_display = get_vcard_categories($cards);
	
    $i = 0;
	$store_vcard = new StoreVcard();
	$id_group = $store_vcard->Add_newsletter_import_group($usercard->user_id);
	//se sono presenti vcards nell'array $cards 
	if($cards){
		//scorro tutte le vcard
		foreach ($cards as $card_name => $card) {
			if(SHOW_DEBUG){
				echo "<br/><br/>--------INIZIO DELLA VCARD----------<br/>";
			}
			//creo una $store_vcard che conterrà tutte le variabili della vcard per salvarla nel DB
			$store_vcard = new StoreVcard();
			
			
			//se non ci sono categorie da visualizzare (impossibile perchè $categories_to_display comprende tutte le categorie della card) ma lo lascio lo stesso non si sa mai !
			if (!$card->inCategories($categories_to_display)) {
				continue;
			}
			
			
			//stampa la vcard
			
			//array delle proprietà da scorrere per salvare la vcard
			$names = array('N', 'TITLE', 'ORG', 'TEL', 'EMAIL', 'URL', 'ADR', 'BDAY', 'NOTE', 'NICKNAME', 'ROLE', 'SORT-STRING', 'MAILER'/*,'KEY'*/,'ANNIVERSARY','CALADRURI','CALURI','CATEGORIES','CLIENTPIDMAP','FBURL','GENDER','GEO','IMPP','KIND','LOGO','MEMBER','PHOTO','PRODID','RELATED','SOUND','SOURCE','TZ','UID','XML');
			
			foreach ($names as $name) {
				$properties = $card->getProperties($name);
				$html = "";
				switch($name){
					case 'N': case 'n':			
						if ($properties) {
							foreach ($properties as $property) {
								$components = $property->getComponents();
								if(SHOW_DEBUG){
									$html .= "NOME: ".$components[1]."<br/>";
									$html .= "MIDDLENAME: ".$components[2]."<br/>";
									$html .= "COGNOME: ".$components[0];
									$html .= "ADDON: ".$components[3];
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								//salvo nella $store_vcard i valori
								$store_vcard->setLastName($components[0]);
								$store_vcard->setFirstName($components[1]);
								$store_vcard->setMiddleName($components[2]);
								$store_vcard->setAddon($components[3]);
							}
						}
					break;
					 
					case 'ROLE': case 'Role': case 'role':			
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html .= "ROLE: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setRole($value);
							}
						}
					break;
					
					case 'ANNIVERSARY': case 'Anniversary': case 'anniversary':			
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html .= "ANNIVERSARY: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setAnniversary($value);
							}
						}
					break;
					
					case 'IMPP': case 'Impp': case 'impp':			
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html .= "IMPP: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setImpp($value);
							}
						}
					break;
					
					case 'GEO': case 'Geo': case 'geo':			
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html .= "GEO: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setGeo($value);
							}
						}
					break;
					
					case 'GENDER': case 'Gender': case 'gender':			
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html .= "GENDER: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setGender($value);
							}
						}
					break;
					
					case 'FBURL': case 'Fburl': case 'fburl':			
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html .= "FBURL: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setFburl($value);
							}
						}
					break;
					
					case 'CLIENTPIDMAP': case 'Clientpidmap': case 'clientpidmap':			
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html .= "CLIENTPIDMAP: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setClientpidmap($value);
							}
						}
					break;
					
					case 'CATEGORIES': case 'Categories': case 'categories':			
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html .= "CATEGORIES: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setCategories($value);
							}
						}
					break;
					
					case 'CALURI': case 'Caluri': case 'caluri':			
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html .= "CALURI: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setCaluri($value);
							}
						}
					break;
					
					case 'CALADRURI': case 'Caladruri': case 'caladruri':			
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html .= "BDAY: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setCaladruri($value);
							}
						}
					break;
					
					case 'BDAY': case 'Bday': case 'bday':			
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html .= "BDAY: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setBirthday($value);
							}
						}
					break;
					
					case 'TITLE': case 'Title': case 'title':			
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html .= "TITLE: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setJobTitle($value);
							}
						}
					break;
					case 'NOTE': case 'Note': case 'note':			
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html .= "NOTE: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setNote($value);
							}
						}
					break;
					
					case 'SORT-STRING': case 'Sort-String':case 'sort-string':
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html = "SORT-STRING: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setSortstring($value);
							}
						}
					break;
					
					case 'NICKNAME': case 'Nickname': case 'nickname':		
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html = "NICKNAME: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setNickname($value);
							}
						}
					break;
					
					case 'MAILER': case 'Mailer': case 'mailer':		
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html = "MAILER: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setMailer($value);
							}
						}
					break;
					//,'KIND','LOGO','MEMBER','PHOTO','PRODID','RELATED','SOUND','SOURCE','TZ','UID','XLM'
					case 'XML': case 'Xml': case 'xml':		
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html = "XML: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setXml($value);
							}
						}
					break;

					
					case 'UID': case 'Uid': case 'uid':		
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html = "UID: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setUid($value);
							}
						}
					break;

					
					case 'TZ': case 'Tz': case 'tz':		
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html = "TZ ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setTz($value);
							}
						}
					break;

					
					case 'SOURCE': case 'Source': case 'source':		
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html = "SOURCE: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setSource($value);
							}
						}
					break;

					
					case 'SOUND': case 'Sound': case 'sound':		
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html = "SOUND: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setSound($value);
							}
						}
					break;

					
					case 'RELATED': case 'Related': case 'related':		
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html = "RELATED: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setRelated($value);
							}
						}
					break;

					
					case 'PRODID': case 'Prodid': case 'prodid':		
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html = "PRODID: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setProdid($value);
							}
						}
					break;


					case 'PHOTO': case 'Photo': case 'photo':		
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html = "PHOTO: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setPhoto($value);
							}
						}
					break;

					
					case 'MEMBER': case 'Member': case 'member':		
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html = "MEMBER: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setMember($value);
							}
						}
					break;
					
					case 'LOGO': case 'Logo': case 'logo':		
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html = "LOGO: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setLogo($value);
							}
						}
					break;
					
					case 'KIND': case 'Kind': case 'kind':		
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html = "KIND: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setKind($value);
							}
						}
					break;
					
					/*case 'KEY': case 'Key': case 'key':		
						if ($properties) {
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html = "KEY: ".$value."<br/>";
									
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard i valori
								$store_vcard->setKey($value);
							}
						}
					break;*/
					
					
					case 'ORG':	case 'Org':	case 'org':			
						if ($properties) {
							foreach ($properties as $property) {
								$components = $property->getComponents();
								if(SHOW_DEBUG){
									$html .= "ORGANISATION 1: ".$components[0]."<br/>";
									$html .= "DEPARTEMENT 2: ".$components[1]."<br/>";
									
									echo nl2br(stripcslashes($html));
								}
								//salvo nella $store_vcard i valori
								$store_vcard->setOrganisation($components[0]);
								$store_vcard->setDepartment($components[1]);
							}
						}
					break;
					
					case 'URL':	case 'Url':	case 'url':
								
						if ($properties) {
							foreach ($properties as $property) {
								//prendo il valore della $property
								$value = $property->value;
								//prendo tutti i parametri di tipo $property 
								$types = $property->params['TYPE'];
								
								if ($types) {
									//switch in base al primo parametro
									switch($types[0]){
										case "WORK": case "work": case "Work":			
											$value = $property->value;
											if(SHOW_DEBUG){
												
												$html = "URL WORK: ".$value."<br/>";
												
												echo nl2br(stripcslashes($html));
												echo "<br/>";
											}
											
											//salvo nella $store_vcard i valori
											$store_vcard->setURLWork($value);
										break;
										
										case "HOME": case "Home": case "home":		
											$value = $property->value;
											if(SHOW_DEBUG){
												$html = "URL HOME: ".$value."<br/>";
												
												echo nl2br(stripcslashes($html));
												echo "<br/>";
											}
											
											//salvo nella $store_vcard i valori
											$store_vcard->setURLHome($value);
										break;
										
										default:	
											$value = $property->value;
											if(SHOW_DEBUG){
												$html = "URL DEFAULT: ".$value."<br/>";
												
												echo nl2br(stripcslashes($html));
												echo "<br/>";
											}
											
											//salvo nella $store_vcard i valori
											$store_vcard->setURLHome($value);
										break;
									}
								}else{
									$value = $property->value;
									if(SHOW_DEBUG){
										$html = "URL DEFAULT: ".$value."<br/>";
										
										echo nl2br(stripcslashes($html));
										echo "<br/>";
									}
									
									//salvo nella $store_vcard i valori
									$store_vcard->addURL($value);	
								}//end if
							}//end foreach
						}//end if
					break;
					case 'ADR':	case 'Adr':	case 'adr':
								
						if ($properties) {
							foreach ($properties as $property) {
								//prendo il valore della $property
								$value = $property->value;
								//prendo tutti i parametri di tipo $property 
								$types = $property->params['TYPE'];
								
								if ($types) {
									//switch in base al primo parametro
									switch($types[0]){
										case "work": case "WORK": case "Work":			
											$components = $property->getComponents();
											if(SHOW_DEBUG){
												$html = "";
												$html .= "-----------------WORK----------------------<br/>";
												$html .= "COMPANY NAME: ".$components[1]."<br/>";
												$html .= "WORK STREET: ".$components[2]."<br/>";
												$html .= "WORK ZIP: ".$components[5]."<br/>";
												$html .= "WORK CITY: ".$components[3]."<br/>";
												$html .= "WORK REGION: ".$components[4]."<br/>";
												$html .= "WORK COUNTRY: ".$components[6]."<br/>";
												$html .= "-----------------END WORK----------------------<br/>";
												echo nl2br(stripcslashes($html));
											}
											//salvo nella $store_vcard i valori
											$store_vcard->setCompany($components[1]); 
											$store_vcard->setWorkStreet($components[2]); 
											$store_vcard->setWorkZIP($components[5]); 
											$store_vcard->setWorkCity($components[3]); 
											$store_vcard->setWorkRegion($components[4]); 
											$store_vcard->setWorkCountry($components[6]);
										break;
										
										case "HOME": case "Home": case "home":		
											$components = $property->getComponents();
											if(SHOW_DEBUG){
												$html = "";
												$html .= "-----------------HOME----------------------<br/>";
												$html .= "HOME STREET: ".$components[2]."<br/>";
												$html .= "HOME ZIP: ".$components[5]."<br/>";
												$html .= "HOME CITY: ".$components[3]."<br/>";
												$html .= "HOME REGION: ".$components[4]."<br/>";
												$html .= "HOME COUNTRY: ".$components[6]."<br/>";
												$html .= "-----------------END HOME----------------------<br/>";
												echo nl2br(stripcslashes($html));
											}
											//salvo nella $store_vcard i valori
											$store_vcard->setHomeStreet($components[2]); 
											$store_vcard->setHomeZIP($components[5]); 
											$store_vcard->setHomeCity($components[3]); 
											$store_vcard->setHomeRegion($components[4]); 
											$store_vcard->setHomeCountry($components[6]);
										break;
										
										case "POSTAL": case "Postal": case "postal":	
											$components = $property->getComponents();
											if(SHOW_DEBUG){
												$html = "";
												$html .= "-----------------POSTAL----------------------<br/>";
												$html .= "POSTAL STREET: ".$components[2]."<br/>";
												$html .= "POSTAL ZIP: ".$components[5]."<br/>";
												$html .= "POSTAL CITY: ".$components[3]."<br/>";
												$html .= "POSTAL REGION: ".$components[4]."<br/>";
												$html .= "POSTAL COUNTRY: ".$components[6]."<br/>";
												$html .= "-----------------END POSTAL----------------------<br/>";
												echo nl2br(stripcslashes($html));
											}
											//salvo nella $store_vcard i valori
											$store_vcard->setPostalStreet($components[2]); 
											$store_vcard->setPostalZIP($components[5]); 
											$store_vcard->setPostalCity($components[3]); 
											$store_vcard->setPostalRegion($components[4]); 
											$store_vcard->setPostalCountry($components[6]);
										break;
									}
								}//end if
							}//end foreach
						}//end if
					break;
					
					
					
					case 'EMAIL': case 'Email': case 'email':			
						if ($properties) {
							$count_emails = 0;
							foreach ($properties as $property) {
								$value = $property->value;
								if(SHOW_DEBUG){
									$html = "EMAIL $count_emails: $value";
									$count_emails++;
									echo nl2br(stripcslashes($html));
									echo "<br/>";
								}
								
								//salvo nella $store_vcard la email
								$store_vcard->addEMail($value);
							}
						}
					break;
					
					case 'TEL':	case 'Tel':	case 'tel':			
						if ($properties) {
							//contatore tel work trovati
							$count_tel_work = 0;
							//contatore tel home trovati
							$count_tel_homr = 0;
							foreach ($properties as $property) {
								//prendo il valore della $property
								$value = $property->value;
								//prendo tutti i parametri di tipo $property 
								$types = $property->params['TYPE'];
								
								if ($types) {
									//switch in base al primo parametro
									switch($types[0]){
										case "voice": case "VOICE": case "Voice":
											//se c'è secondo parametro switch in base al secondo parametro
											if($types[1]){
												switch($types[1]){
													//se il telefono è VOICE;WORK
													case "WORK": case "Work": case "work":
														if(SHOW_DEBUG)
															echo "TEL WORK $count_tel_work: ".$value."<br/>";
														if($count_tel_work==0)
															$store_vcard->setTelephoneWork1($value);
														else
															$store_vcard->setTelephoneWork2($value);
														//incremento il contatore dei telefoni WORK trovati
														$count_tel_work++;
													break;
													//se il telefono è VOICE;HOME o qualcos'altro
													case "HOME": case "Home": case "home":
														if(SHOW_DEBUG)
															echo "TEL HOME $count_tel_home: ".$value."<br/>";
														if($count_tel_work==0)
															$store_vcard->setTelephoneHome1($value);
														else
															$store_vcard->setTelephoneHome2($value);
														//incremento il contatore dei telefoni WORK trovati
														$count_tel_work++;
													break;
												}
											}else{//se è solo TEL;WORK
												if(SHOW_DEBUG)
													echo "TEL ADDITIONAL $count_tel_work: ".$value."<br/>";
												
												$store_vcard->setAdditionalTelephone($value);
											}
										break;
										
										
										case "FAX": case "Fax": case "Fax":
											//se c'è secondo parametro switch in base al secondo parametro
											if($types[1]){
												switch($types[1]){
													//se il telefono è FAX;WORK
													case "WORK": case "Work": case "work":
														if(SHOW_DEBUG)
															echo "TEL FAX WORK: ".$value."<br/>";
														$store_vcard->setFaxWork($value);
													break;
													//se il telefono è FAX;HOME o qualcos'altro
													case "HOME": case "Home": case "home":
														if(SHOW_DEBUG)
															echo "TEL FAX HOME: ".$value."<br/>";
														
														$store_vcard->setFaxHome($value);
													break;
												}
											}else{//se è solo TEL;FAX
												if(SHOW_DEBUG)
													echo "TEL FAX: ".$value."<br/>";
												$store_vcard->setFaxHome($value);
											}
										break;
										
										
										
										
										
										case "work": case "WORK": case "Work":
											//se c'è secondo parametro switch in base al secondo parametro
											if($types[1]){
												
												switch($types[1]){
													//se il telefono è WORK;FAX
													case "FAX": case "Fax": case "fax":
														if(SHOW_DEBUG)
															echo "TELEFONO FAX: ".$value."<br/>";
														
														$store_vcard->setFaxWork($value);
													break;
													//se il telefono è WORK;VOICE o qualcos'altro
													default:
														if(SHOW_DEBUG)
															echo "TEL WORK $count_tel_work: ".$value."<br/>";
														if($count_tel_work==0)
															$store_vcard->setTelephoneWork1($value);
														else
															$store_vcard->setTelephoneWork2($value);
														//incremento il contatore dei telefoni WORK trovati
														$count_tel_work++;
													break;
												}
											}else{//se è solo TEL;WORK
												if(SHOW_DEBUG)
															echo "TEL WORK $count_tel_work: ".$value."<br/>";
												if($count_tel_work==0)
													$store_vcard->setTelephoneWork1($value);
												else
													$store_vcard->setTelephoneWork2($value);
												//incremento il contatore dei telefoni WORK trovati
												$count_tel_work++;
											}
										break;
										case "HOME": case "Home": case "home":
											//se c'è secondo parametro switch in base al secondo parametro
											if($types[1]){
												
												switch($types[1]){
													//se il telefono è HOME;FAX
													case "FAX": case "Fax": case "fax":
														if(SHOW_DEBUG)
															echo "TELEFONO HOME FAX: ".$value."<br/>";
														
														$store_vcard->setFaxHome($value);
													break;
													//se il telefono è HOME;VOICE o qualcos'altro
													default:
														if(SHOW_DEBUG)
															echo "TEL HOME $count_tel_home: ".$value."<br/>";
														if($count_tel_home==0)
															$store_vcard->setTelephoneHome1($value);
														else
															$store_vcard->setTelephoneHome2($value);
														//incremento il contatore dei telefoni HOME trovati
														$count_tel_home++;
													break;
												}
											}else{//se è solo TEL;HOME
												if(SHOW_DEBUG)
															echo "TEL HOME $count_tel_home: ".$value."<br/>";
												if($count_tel_home==0)
													$store_vcard->setTelephoneHome1($value);
												else
													$store_vcard->setTelephoneHome2($value);
												//incremento il contatore dei telefoni WORK trovati
												$count_tel_home++;
											}
										
										break;
										case "CELL": case "Cell": case "cell":
											if(SHOW_DEBUG)
												echo "TEL CELL : ".$value."<br/>";
											$store_vcard->setCellphone($value);
										break;
										case "CAR": case "Car": case "car":
											if(SHOW_DEBUG)
												echo "TEL CAR : ".$value."<br/>";
											$store_vcard->setCarphone($value);
										break;
										case "PAGER": case "Pager": case "pager":
											if(SHOW_DEBUG)
												echo "TEL PAGER : ".$value."<br/>";
											$store_vcard->setPager($value);
										break;
										case "ISDN": case "Isdn": case "isdn":
											if(SHOW_DEBUG)
												echo "TEL ISDN : ".$value."<br/>";
											$store_vcard->setISDN($value);
										break;
										case "PREF": case "Pref": case "pref":
											if(SHOW_DEBUG)
												echo "TEL PREF : ".$value."<br/>";
											$store_vcard->setPreferredTelephone($value);
										break;
										default:
											if(SHOW_DEBUG)
												echo "ADDITIONAL TEL : ".$value."<br/>";
											$store_vcard->setAdditionalTelephone($value);
										
										break;
									}
								}
							}
						}
					break;
				}
			}
			
			$store_vcard->storeinDB($usercard->user_id,$id_group);
			
			if(SHOW_DEBUG){
				$store_vcard->writeCardFile();
				//output_file("vcarddownload/".$store_vcard->getCardFileName(), "prova.vcf");
			}
			
			if(SHOW_DEBUG)
				echo "VECCHIA VISUALIZZAZIONE:<br/>";
			
			if(SHOW_DEBUG){
				//per ogni elemento dell'array $names
				foreach ($names as $name) {
					
					$properties = $card->getProperties($name);
					if ($properties) {
						foreach ($properties as $property) {
							print_vcard_property($property);
							echo "<br/>";
						}
					}
				}
			}
			
			/*
			if(SHOW_DEBUG){
				echo "StoreVcard OUTPUT: <br/>";
				echo $store_vcard->getCardOutput();
				
				echo "<br/><br/>--------FINE DELLA VCARD----------<br/>";
			}
			*/
			//FINE DELLA VCARD
		}
	}
}


function output_file($file, $name, $mime_type='')
	{
	 /*
	 This function takes a path to a file to output ($file),
	 the filename that the browser will see ($name) and
	 the MIME type of the file ($mime_type, optional).
	 
	 If you want to do something on download abort/finish,
	 register_shutdown_function('function_name');
	 */
	 if(!is_readable($file)) die('Il file è inesistente o non è accessibile! ');
	 
	 $size = filesize($file);
	 $name = rawurldecode($name);
	 
	 /* Figure out the MIME type (if not specified) */
	 $known_mime_types=array(
		"pdf" => "application/pdf",
		"txt" => "text/plain",
		"html" => "text/html",
		"htm" => "text/html",
		"exe" => "application/octet-stream",
		"zip" => "application/zip",
		"doc" => "application/msword",
		"xls" => "application/vnd.ms-excel",
		"ppt" => "application/vnd.ms-powerpoint",
		"gif" => "image/gif",
		"png" => "image/png",
		"jpeg"=> "image/jpg",
		"jpg" =>  "image/jpg",
		"php" => "text/plain"
	 );
	 
	 if($mime_type==''){
		 $file_extension = strtolower(substr(strrchr($file,"."),1));
		 if(array_key_exists($file_extension, $known_mime_types)){
			$mime_type=$known_mime_types[$file_extension];
		 } else {
			$mime_type="application/force-download";
			
		 };
	 };
	 
	 @ob_end_clean(); //turn off output buffering to decrease cpu usage
	 
	 // required for IE, otherwise Content-Disposition may be ignored
	 if(ini_get('zlib.output_compression'))
	  ini_set('zlib.output_compression', 'Off');
	 header('Content-Type: ' . $mime_type);
	 header('Content-Disposition: attachment; filename="'.$name.'"');
	 header("Content-Transfer-Encoding: binary");
	 header('Accept-Ranges: bytes');
	 /* The three lines below basically make the
		download non-cacheable */
	 header("Cache-control: private");
	 header('Pragma: private');
	 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	 
	 // multipart-download and download resuming support
	 if(isset($_SERVER['HTTP_RANGE']))
	 {
		list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
		list($range) = explode(",",$range,2);
		list($range, $range_end) = explode("-", $range);
		$range=intval($range);
		if(!$range_end) {
			$range_end=$size-1;
		} else {
			$range_end=intval($range_end);
		}
	 
		$new_length = $range_end-$range+1;
		header("HTTP/1.1 206 Partial Content");
		header("Content-Length: $new_length");
		header("Content-Range: bytes $range-$range_end/$size");
	 } else {
		$new_length=$size;
		header("Content-Length: ".$size);
	 }
	 
	 /* output the file itself */
	 $chunksize = 1*(1024*1024); //you may want to change this
	 $bytes_send = 0;
	 if ($file = fopen($file, 'r'))
	 {
		if(isset($_SERVER['HTTP_RANGE']))
		fseek($file, $range);
	 
		while(!feof($file) &&
			(!connection_aborted()) &&
			($bytes_send<$new_length)
			  )
		{
			$buffer = fread($file, $chunksize);
			print($buffer); //echo($buffer); // is also possible
			flush();
			$bytes_send += strlen($buffer);
		}
	 fclose($file);
	 } else die('Error - can not open file.');
	 
	die();
	}   

/**
 * Prints a VCardProperty as HTML.
 */
function print_vcard_property($property)
{
    $name = $property->name;
    $value = $property->value;
	
    switch ($name) {
        case 'ADR':
            $adr = $property->getComponents();
            $lines = array();
            for ($i = 0; $i < 3; $i++) {
                if ($adr[$i]) {
                    $lines[] = $adr[$i];
                }
            }
            $city_state_zip = array();
            for ($i = 3; $i < 6; $i++) {
                if ($adr[$i]) {
                    $city_state_zip[] = $adr[$i];
                }
            }
            if ($city_state_zip) {
                // Separate the city, state, and zip with spaces and add
                // it as the last line.
                $lines[] = join("&nbsp;", $city_state_zip);
            }
            // Add the country.
            if ($adr[6]) {
                $lines[] = $adr[6];
            }
            $html = join("\n", $lines);
            break;
        case 'EMAIL':
            $html = "EMAIL: $value";
            break;
        case 'URL':
            $html = "URL: $value";
            break;
        case 'BDAY':
            $html = "Birthdate: $value";
            break;
		case 'N':
            $components = $property->getComponents();
			
            $html .= "NOME: ".$components[1]."<br/>";
			$html .= "MIDDLENAME: ".$components[2]."<br/>";
			$html .= "COGNOME: ".$components[0];
            break;
        default:
			
            $components = $property->getComponents();
            $lines = array();
            foreach ($components as $component) {
                if ($component) {
                    $lines[] = $component;
                }
            }
            $html = "DEFAULT: ".join("\n", $lines);
            break;
    }
	
    echo nl2br(stripcslashes($html));
    
	$types = $property->params['TYPE'];
	
    if ($types) {
        $type = join(", ", $types);
        echo " (" . ucwords(strtolower($type)) . ")";
    }
	
}

function get_vcard_categories(&$cards)
{
    $unfiled = false;   // set if there is at least one unfiled card
    $result = array();
	if($cards){
		foreach ($cards as $card_name => $card) {
			$properties = $card->getProperties('CATEGORIES');
			if ($properties) {
				foreach ($properties as $property) {
					$categories = $property->getComponents(',');
					foreach ($categories as $category) {
						if (!in_array($category, $result)) {
							$result[] = $category;
						}
					}
				}
			} else {
				$unfiled = true;
			}
		}
	}
    if ($unfiled && !in_array('Unfiled', $result)) {
        $result[] = 'Unfiled';
    }
    return $result;
}


// ----- Utility Functions -----

/**
 * Checks if needle $str is in haystack $arr but ignores case.
 */
function in_array_case($str, $arr)
{
    foreach ($arr as $s) {
        if (strcasecmp($str, $s) == 0) {
            return true;
        }
    }
    return false;
}

/*
 * Prints the vCard as HTML.*/
function print_vcard($card)
{
    $names = array('FN', 'TITLE', 'ORG', 'TEL', 'EMAIL', 'URL', 'ADR', 'BDAY', 'NOTE');

    $row = 0;
	
	//per ogni elemento dell'array $names
    foreach ($names as $name) {
		
        $properties = $card->getProperties($name);
        if ($properties) {
            foreach ($properties as $property) {
				
				//questo boh
                $types = $property->params['TYPE'];
				
                
                print_vcard_property($property);
				echo "<br/>";
                
            }
        }
    }
}



/**
 * Prints a set of vCards in two columns. The $categories_to_display is a
 * comma delimited list of categories.
 */   
function print_vcards(&$cards)
{
	//processo tutte le categorie
    $categories_to_display = get_vcard_categories($cards);
	
    $i = 0;
	if($cards){
		foreach ($cards as $card_name => $card) {
			
			echo "<br/><br/>--------INIZIO DELLA VCARD----------<br/>";
			
			//se non ci sono categorie da visualizzare (impossibile perchè $categories_to_display comprende tutte le categorie della card) ma lo lascio lo stesso non si sa mai !
			if (!$card->inCategories($categories_to_display)) {
				continue;
			}
			
			
			// Add the categories (if present) after the name.
			$property = $card->getProperty('CATEGORIES');
			if ($property) {
				// Replace each comma by a comma and a space.
				$categories = $property->getComponents(',');
				$categories = join(', ', $categories);
				echo "TUTTE LE CATEGORIE: ($categories)<br/><br/>";
			}
			
			//stampa la vcard
			print_vcard($card);
			
			echo "<br/><br/>--------FINE DELLA VCARD----------<br/>";
			//FINE DELLA VCARD
		}
	}
}
	$card= new Card(NULL,$username);
	unlink("../../tmp_vcf/".$file_name);
	?>
    	
		<script language="javascript" type="text/javascript">
		var results_text = "<?= trim($results_text) ?>";
		
		window.parent.alert(results_text);
        window.parent.Show_mailing_groups(0); 
		window.parent.Show_mailing_groups(<? echo (count($card->newsletter_group)-1); ?>);
        window.parent.document.getElementById("mailing_loading").style.display = "none";</script>
    <?php
   // visualizzo scritta direttamente da alert
   /*echo "
      <script type='text/javascript'>
         alert( 'Hello Word!!' );
		 window.parent.Show_mailing_groups(0);
		window.parent.alert('";
		echo $results_text;
		echo "');
      </script>
   ";*/
	
?> 