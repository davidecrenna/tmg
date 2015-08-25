<?php
	include("../../headerdownload.php");
	$username = $_GET['u'];
  	$card= new Card(NULL,$username);
	$download_dir="";
	$lang="";
	
	$vCard = new StoreVcard($lang,$download_dir);
	$vCard->setLastName($card->Get_nome());
	$vCard->setFirstName($card->Get_cognome()); 
	//$vCard->setMiddleName('Mobil');
	//$vCard->setOrganisation('Linux'); 
	//$vCard->setDepartment('Product Placement'); 
	$vCard->setJobTitle($card->Get_professione());
	
	$vCard->setNote($card->sudime);
	
	/*$vCard->setTelephoneWork1('+43 (05555) 000001'); 
	$vCard->setTelephoneWork2('+43 (05555) 000002'); 
	$vCard->setTelephoneHome1('+43 (05555) 000003'); 
	$vCard->setTelephoneHome2('+43 (05555) 000004');*/ 
	$vCard->setCellphone($card->cellulare); 
	/*$vCard->setCarphone('+43 (05555) 000006'); 
	$vCard->setPager('+43 (05555) 000007'); 
	$vCard->setAdditionalTelephone('+43 (05555) 000008'); 
	$vCard->setFaxWork('+43 (05555) 000009'); 
	$vCard->setFaxHome('+43 (05555) 000010'); 
	$vCard->setISDN('+43 (05555) 000011'); 
	$vCard->setPreferredTelephone('+43 (05555) 000012');*/
	$vCard->addEMail($card->Get_member_email());
	$vCard->addEMail($card->email); 
	//$vCard->addEMail('flaimo3@gmx.net'); 
	//$vCard->addEMail('flaimo4@gmx.net'); 
	//$vCard->setAddon('sen.'); 
	$vCard->setNickname($card->username);
	//$vCard->setCompany('Microsoft'); 
	//$vCard->setWorkStreet('via della ditta'); 
	//$vCard->setWorkZIP('11111'); 
	//$vCard->setWorkCity('Testcity ditta'); 
	//$vCard->setWorkRegion('regione della ditta'); 
	//$vCard->setWorkCountry('stato della ditta');
	//$vCard->setHomeStreet('via di casa'); 
	//$vCard->setHomeZIP('11111');
	//$vCard->setHomeCity('Testcity casa');
	//$vCard->setHomeRegion('regione della casa');
	//$vCard->setHomeCountry('stato della casa');
	//$vCard->setPostalStreet('via postal');
	//$vCard->setPostalZIP('11111');
	//$vCard->setPostalCity('Testcity postal');
	//$vCard->setPostalRegion('regione postal');
	//$vCard->setPostalCountry('stato postal');
	$vCard->setURLHome("www.topmanagergroup.com/".$card->username);
	/*if($card->link_fb!="")
		$vCard->AddURL($card->link_fb); 
	*/
	//$vCard->setRole('Student');
	//$vCard->setBirthday(time());
	/*
	header('Content-Type: text/x-vcard'); 
	header('Content-Disposition: inline; filename=vCard_' . date('Y-m-d_H-m-s') . '.vcf'); 
	echo $vCard->getCardOutput(); */
	$vCard->writeCardFile();
	//header('Location:' . $vCard->getCardFilePath());
	
	
	//echo $vCard->getCardFilePath();
	output_file("vcarddownload/".$vCard->getCardFileName(), $card->username.".vcf");
	//nome della vcard generata
	//echo $vCard->getCardFileName(); 
	
	
/*	header ("Content-type: application/download");
	header ("Content-Disposition: attachment; filename=prova.vcf");  
	header('Location:' . $vCard->getCardFilePath());*/
	
	
	//output_file($vCard->getCardFilePath(), "prova.vcf"); 
	
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
	
?>

<?php 
/*include_once('class.vCard.inc.php'); 
$vCard = (object) new vCard('',''); 

$vCard->setFirstName('Max'); 
$vCard->setMiddleName('Mobil'); 
$vCard->setLastName('Mustermann'); 
$vCard->setEducationTitle('Doctor'); 
$vCard->setAddon('sen.'); 
$vCard->setNickname('Maxi'); 
$vCard->setCompany('Microsoft'); 
$vCard->setOrganisation('Linux'); 
$vCard->setDepartment('Product Placement'); 
$vCard->setJobTitle('CEO'); 
$vCard->setNote('Additional Note go here'); 
$vCard->setTelephoneWork1('+43 (05555) 000000'); 
$vCard->setTelephoneWork2('+43 (05555) 000000'); 
$vCard->setTelephoneHome1('+43 (05555) 000000'); 
$vCard->setTelephoneHome2('+43 (05555) 000000'); 
$vCard->setCellphone('+43 (05555) 000000'); 
$vCard->setCarphone('+43 (05555) 000000'); 
$vCard->setPager('+43 (05555) 000000'); 
$vCard->setAdditionalTelephone('+43 (05555) 000000'); 
$vCard->setFaxWork('+43 (05555) 000000'); 
$vCard->setFaxHome('+43 (05555) 000000'); 
$vCard->setISDN('+43 (05555) 000000'); 
$vCard->setPreferredTelephone('+43 (05555) 000000'); 
$vCard->setTelex('+43 (05555) 000000'); 
$vCard->setWorkStreet('123 Examplestreet'); 
$vCard->setWorkZIP('11111'); 
$vCard->setWorkCity('Testcity'); 
$vCard->setWorkRegion('PA'); 
$vCard->setWorkCountry('USA'); 
$vCard->setHomeStreet('123 Examplestreet'); 
$vCard->setHomeZIP('11111'); 
$vCard->setHomeCity('Testcity'); 
$vCard->setHomeRegion('PA'); 
$vCard->setHomeCountry('USA'); 
$vCard->setPostalStreet('123 Examplestreet'); 
$vCard->setPostalZIP('11111'); 
$vCard->setPostalCity('Testcity'); 
$vCard->setPostalRegion('PA'); 
$vCard->setPostalCountry('USA'); 
$vCard->setURLWork('http://flaimo.com'); 
$vCard->setRole('Student'); 
$vCard->setBirthday(time()); 
$vCard->setEMail('flaimo@gmx.net'); 

$vCard->writeCardFile(); 
header('Location:' . $vCard->getCardFilePath()); 
exit; 
*/
?> 