<?php

/**
* Crea una vcard per scriverla su un file o salvarla nel DB
*
*
* @access public
* @author Davide Crenna
* @copyright Davide Crenna
* @link http://www.topmanagergroup.com/davidecrenna
* @package card/class
* @version 1.000
*/
class StoreVcard
  {
  
  /*-------------------*/
  /* V A R I A B L E S */
  /*-------------------*/
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */   
  var $first_name;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */   
  var $middle_name;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $last_name;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $edu_title;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $addon;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $nickname;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $company;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $organisation;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $department;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $job_title;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $note;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $tel_work1_voice;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $tel_work2_voice;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $tel_home1_voice;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $tel_home2_voice;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $tel_cell_voice;
 
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $tel_car_voice;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $tel_pager_voice;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $tel_additional;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $tel_work_fax;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $tel_home_fax;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $tel_isdn;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $tel_preferred;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $work_street;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $work_zip;
 
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $work_city;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $work_region;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $work_country;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $home_street;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $home_zip;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $home_city;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $home_region;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $home_country;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $postal_street;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $postal_zip;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */   
  var $postal_city;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $postal_region;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $postal_country;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $url_work;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $url = array();
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $url_home;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $role;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $birthday;
  
  /**
  * No information available
  *
  * @var array string
  * @access private
  */ 
  var $email = array();

  
  /**
  * No information available
  *
  * @var string
  * @access private
  */   
  var $rev; 
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $lang;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $mailer;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $sortstring;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $anniversary;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $caladruri;
  
    /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $caluri;
  
    /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $categories;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $clientpidmap;

/**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $fburl;

/**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $gender;

/**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $geo;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $impp;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $varkey;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $logo;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $member;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $photo;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $prodid;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $related;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $sound;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $source;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $tz;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $uid;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $xml;
  
  /**
  * No information available
  *
  * @var string
  * @access private
  */ 
  var $kind;
  
  private $mysql_database;
  

  /*-----------------------*/
  /* C O N S T R U C T O R */
  /*-----------------------*/

  /**
  * Constructor
  *
  * Only job is to set all the variablesnames
  *
  * @param (string) $downloaddir
  * @param (string) $lang
  * @return (void)
  * @access private
  * @since 1.000 - 2002/10/10   
  */
  function StoreVcard($downloaddir = '', $lang = '')
    {
		$this->mysql_database = new MySqlDatabase();
    	$this->download_dir = (string) ((strlen(trim($downloaddir)) > 0) ? $downloaddir : 'vcarddownload');
    	$this->card_filename = (string) time() . '.vcf';
    	$this->rev = (string) date('Ymd\THi00\Z',time());
    	$this->setLanguage($lang);
    	if ($this->checkDownloadDir() == false)
        {
      		die('error creating download directory');
      	} // end if
    } // end function
  
  
  /*-------------------*/    
  /* F U N C T I O N S */
  /*-------------------*/
  
  /**
  * Checks if the download directory exists, else trys to create it
  *
  * @return (boolean)
  * @access private
  * @since 1.000 - 2002/10/10   
  */
  function checkDownloadDir()
    {
    if (!is_dir($this->download_dir))
      {
      if (!mkdir($this->download_dir, 0700))
        {
        return (boolean) false;
        }
      else
        {
        return (boolean) true;
        } // end if
      }
    else
      {
      return (boolean) true;
      } // end if
    } // end function  
  
  /**
  * Set Language (iso code) for the Strings in the vCard file
  *
  * @param (string) $isocode
  * @return (void)
  * @access private
  * @since 1.000 - 2002/10/10   
  */
  function setLanguage($isocode = '')
    {
    if ($this->isValidLanguageCode($isocode) == true)
      {
      $this->lang = (string) ';LANGUAGE=' . $isocode;
      }
    else
      {
      $this->lang = (string) '';
      } // end if
    } // end function
  
  /**
  * Encodes a string for QUOTE-PRINTABLE
  *
  * @param (string) $quotprint  String to be encoded
  * @return (string)  Encodes string
  * @access private
  * @since 1.000 - 2002/10/20 
  * @author Harald Huemer <harald.huemer@liwest.at>
  */
  function quotedPrintableEncode($quotprint)
    { 
    /*
    //beim Mac Umlaute nicht kodieren !!!! sonst Fehler beim Import
    if ($progid == 3)
      {
      $quotprintenc = preg_replace("~([\x01-\x1F\x3D\x7F-\xBF])~e", "sprintf('=%02X', ord('\\1'))", $quotprint);  
      return($quotprintenc);
      }
    //bei Windows und Linux alle Sonderzeichen kodieren
    else
      {*/
    	return (string) preg_replace("~([\x01-\x1F\x3D\x7F-\xFF])~e", "sprintf('=%02X', ord('\\1'))", $quotprint);  
    } // end function

  /**
  * Checks if a given string is a valid iso-language-code
  *
  * @param (string) $code  String that should validated
  * @return (boolean) $isvalid  If string is valid or not
  * @access private
  * @since 1.000 - 2002/10/20 
  */
  function isValidLanguageCode($code)  // PHP5: protected
    {
    $isvalid = (boolean) false;
    if (preg_match('(^([a-z]{2})$|^([a-z]{2}_[a-z]{2})$|^([a-z]{2}-[a-z]{2})$)',trim($code)) > 0)
      {
      $isvalid = (boolean) true;
      } // end if
    return (boolean) $isvalid;  
    } // end function
  

  /**
  * Set the persons first name
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20   
  A structured representation of the name of the person, place or thing associated with the vCard object.
  */
  function setFirstName($input)
    {
    $this->first_name = (string) $input;
    } // end function
  
  /**
  * Set the persons middle name(s)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20   
  A structured representation of the name of the person, place or thing associated with the vCard object.
  */
  function setMiddleName($input)
    {
    $this->middle_name = (string) $input;
    } // end function
    
  /**
  * Set the persons last name
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  A structured representation of the name of the person, place or thing associated with the vCard object. 
  */
  function setLastName($input)
    {
    $this->last_name = (string) $input;
    } // end function
    
  /**
  * Set the persons title (Doctor,...)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20   
  Specifies the job title, functional position or function of the individual associated with the vCard object within an organization.
  Example: TITLE:V.P. Research and Development
  */  
  function setEducationTitle($input)
    {
    $this->edu_title = (string) $input;
    } // end function
    
  /**
  * Set the persons addon (jun., sen.,...)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20 
  A structured representation of the name of the person, place or thing associated with the vCard object.  
  */
  function setAddon($input)
    {
    $this->addon = (string) $input;
    } // end function
    
  /**
  * Set the persons nickname
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20 
  One or more descriptive/familiar names for the object represented by this vCard.
  Example: NICKNAME:Jon,Johnny  
  */
  function setNickname($input)
    {
    $this->nickname = (string) $input;
    } // end function
  
  /**
  * Set the company name for which the person works for
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20 
  	Part of structured representation of the physical delivery address for the vCard object.  
  */
  function setCompany($input)
    {
    $this->company = (string) $input;
    } // end function
  
  /**
  * Set the organisations name for which the person works for
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20   
  */
  function setOrganisation($input)
    {
    $this->organisation = (string) $input;
    } // end function
    
  /**
  * Set the department name of company for which the person works for
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20   
  */
  function setDepartment($input)
    {
    $this->department = (string) $input;
    } // end function
    
  /**
  * Set the persons job title
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20   
  */
  function setJobTitle($input)
    {
    $this->job_title = (string) $input;
    } // end function
    
  /**
  * Set additional notes for that person
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20   
  */
  function setNote($input)
    {
    $this->note = (string) $input;
    } // end function
  
  /**
  * Set telephone number (Work 1)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20   
  */
  function setTelephoneWork1($input)
    {
    $this->tel_work1_voice = (string) $input;
    } // end function
    
  /**
  * Set telephone number (Work 2)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20   
  */
  function setTelephoneWork2($input)
    {
    $this->tel_work2_voice = (string) $input;
    } // end function
  
  /**
  * Set telephone number (Home 1)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20   
  */  
  function setTelephoneHome1($input)
    {
    $this->tel_home1_voice = (string) $input;
    } // end function  
  
  /**
  * Set telephone number (Home 2)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20   
  */
  function setTelephoneHome2($input)
    {
    $this->tel_home2_voice = (string) $input;
    } // end function
  
  /**
  * Set cellphone number
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20   
  */
  function setCellphone($input)
    {
    $this->tel_cell_voice = (string) $input;
    } // end function
  
  
  /**
  * Set carphone number
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20   
  */
  function setCarphone($input)
    {
    $this->tel_car_voice = (string) $input;
    } // end function
  
  /**
  * Set pager number
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20   
  */
  function setPager($input)
    {
    $this->tel_pager_voice = (string) $input;
    } // end function  
    
  /**
  * Set additional phone number
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20   
  */
  function setAdditionalTelephone($input)
    {
    $this->tel_additional = (string) $input;
    } // end function  
    
  /**
  * Set fax number (Work)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20   
  */
  function setFaxWork($input)
    {
    $this->tel_work_fax = (string) $input;
    } // end function  
  
  /**
  * Set fax number (Home)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20   
  */
  function setFaxHome($input)
    {
    $this->tel_home_fax = (string) $input;
    } // end function  
  
  
  /**
  * Set ISDN (phone) number
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20   
  */
  function setISDN($input)
    {
    $this->tel_isdn = (string) $input;
    } // end function  
  
  /**
  * Set preferred phone number
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20   
  */
  function setPreferredTelephone($input)
    {
    $this->tel_preferred = (string) $input;
    } // end function  
  
  
  /**
  * Set streetname (Work Address)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20 
  Part of structured representation of the physical delivery address for the vCard object.   
  */
  function setWorkStreet($input)
    {
    $this->work_street = (string) $input;
    } // end function  
  
  /**
  * Set ZIP code (Work Address)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20 
  Part of structured representation of the physical delivery address for the vCard object.   
  */
  function setWorkZIP($input)
    {
    $this->work_zip = (string) $input;
    } // end function  
  
  /**
  * Set city (Work Address)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20 
  Part of structured representation of the physical delivery address for the vCard object.   
  */
  function setWorkCity($input)
    {
    $this->work_city = (string) $input;
    } // end function  
  
  /**
  * Set region (Work Address)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  Part of structured representation of the physical delivery address for the vCard object.  
  */
  function setWorkRegion($input)
    {
    $this->work_region = (string) $input;
    } // end function  
  
  /**
  * Set country (Work Address)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20 
  Part of structured representation of the physical delivery address for the vCard object.   
  */
  function setWorkCountry($input)
    {
    $this->work_country = (string) $input;
    } // end function  
  
  
  /**
  * Set streetname (Home Address)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  Part of structured representation of the physical delivery address for the vCard object.  
  */
  function setHomeStreet($input)
    {
    $this->home_street = (string) $input;
    } // end function  
  
  /**
  * Set ZIP code (Home Address)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20 
  Part of structured representation of the physical delivery address for the vCard object.   
  */
  function setHomeZIP($input)
    {
    $this->home_zip = (string) $input;
    } // end function  
  
  /**
  * Set city (Home Address)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  Part of structured representation of the physical delivery address for the vCard object.  
  */
  function setHomeCity($input)
    {
    $this->home_city = (string) $input;
    } // end function  
  
  /**
  * Set region (Home Address)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20 
  Part of structured representation of the physical delivery address for the vCard object.   
  */
  function setHomeRegion($input)
    {
    $this->home_region = (string) $input;
    } // end function  
  
  /**
  * Set country (Home Address)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  Part of structured representation of the physical delivery address for the vCard object.  
  */
  function setHomeCountry($input)
    {
    $this->home_country = (string) $input;
    } // end function  
    
  
  /**
  * Set streetname (Postal Address)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  Part of structured representation of the physical delivery address for the vCard object.  
  */
  function setPostalStreet($input)
    {
    $this->postal_street = (string) $input;
    } // end function  
  
  /**
  * Set ZIP code (Postal Address)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20 
  Part of structured representation of the physical delivery address for the vCard object.   
  */  
  function setPostalZIP($input)
    {
    $this->postal_zip = (string) $input;
    } // end function  
  
  /**
  * Set city (Postal Address)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20 
  Part of structured representation of the physical delivery address for the vCard object.   
  */
  function setPostalCity($input)
    {
    $this->postal_city = (string) $input;
    } // end function  
  
  /**
  * Set region (Postal Address)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20 
  Part of structured representation of the physical delivery address for the vCard object.   
  */
  function setPostalRegion($input)
    {
    $this->postal_region = (string) $input;
    } // end function  
  
  /**
  * Set country (Postal Address)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20
  Part of structured representation of the physical delivery address for the vCard object.    
  */
  function setPostalCountry($input)
    {
    $this->postal_country = (string) $input;
    } // end function  
  
  
  /**
  * Set URL (Work)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20
  Part of structured representation of the physical delivery address for the vCard object.  
  A URL pointing to a website that represents the person in some way.
  Example: URL;WORK:http://www.johndoe.com    
  */
  function setURLWork($input)
    {
    $this->url_work = (string) $input;
    } // end function  
	
	/**
  * Add URL
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20 
  A URL pointing to a website that represents the person in some way.
  Example: URL:http://www.johndoe.com  
  */
  function AddURL($input)
    {
    $this->url[] = (string) $input;
    } // end function 
	
	  /**
  * Set URL (Home)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20 
  A URL pointing to a website that represents the person in some way.
  Example: URL;HOME:http://www.johndoe.com    
  */
  function setURLHome($input)
    {
    $this->url_home = (string) $input;
    } // end function  
	
	/**
  * Set Caladruri
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  A URL to use for sending a scheduling request to the person's calendar. 
  Example: CALADRURI:http://example.com/calendar/jdoe
  */
  function setCaladruri($input)
    {
    $this->caladruri = (string) $input;
    } // end function 
  
  	/**
  * Set Caluri
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  	A URL to the person's calendar.
	Example: CALURI:http://example.com/calendar/jdoe 
  
  */
  function setCaluri($input)
    {
    $this->caluri = (string) $input;
    } // end function 
  
    /**
  * Set URL (Home)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  A list of "tags" that can be used to describe the object represented by this vCard.
  Example: CATEGORIES:swimmer,biker 
  */
  function setCategories($input)
    {
    $this->categories = (string) $input;
    } // end function 
	
  /**
  * Set role (Student,...)
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  The role, occupation, or business category of the vCard object within an organization.
  Example: ROLE:Executive 
  */
  function setRole($input)
    {
    $this->role = (string) $input;
    } // end function  
  
  
  /**
  * Set birthday
  *
  * @param (int) $timestamp
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20   
  Date of birth of the individual associated with the vCard.
  Example: BDAY:19700310
  */
  function setBirthday($input)
    {
    $this->birthday = (string) $input;
    } // end function  
  
    /**
  * Set anniversary
  *
  * @param (int) $timestamp
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20 
  Defines the person's anniversary.
  Example: ANNIVERSARY:19901021
  */
  function setAnniversary($input)
    {
    $this->anniversary = (string) $input;
    } // end function  
  
  
  /**
  * Set eMail address
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  The address for electronic mail communication with the vCard object. 
  Example: EMAIL:johndoe@hotmail.com
  */
  function addEMail($input)
    {
    $this->email[] = (string) $input;
    } // end function  
  
    /**
  * Set sort-string
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20 
  Defines a string that should be used when an application sorts this vCard in some way.

* Not supported in version 4.0. Instead, this information is stored in the SORT-AS parameter of the N and/or ORG properties.
	SORT-STRING:Doe  
  */
  function setSortstring($input)
    {
    $this->sortstring = (string) $input;
    } // end function
	
 /**
  * Set mailer
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20
  Type of email program used.
  Example: MAILER:Thunderbird 
  */
  function setMailer($input)
    {
    $this->mailer = (string) $input;
    } // end function
	
	
	
	 /**
  * Set Clientpidmap
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20 
  	Used for synchronizing different revisions of the same vCard.
	Example: CLIENTPIDMAP:1;urn:uuid:3df403f4-5924-4bb7-b077-3c711d9eb34b  
  */
  function setClientpidmap($input)
    {
    $this->clientpidmap = (string) $input;
    } // end function

 /**
  * Set Fburl
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  	Defines a URL that shows when the person is "free" or "busy" on their calendar.
	Example: FBURL:http://example.com/fb/jdoe
  */
  function setFburl($input)
    {
    $this->fburl = (string) $input;
    } // end function	

 /**
  * Set gender
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  	Defines the person's gender.
	Example: GENDER:F
  */
  function setGender($input)
    {
    $this->gender = (string) $input;
    } // end function

 /**
  * Set geo
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  	Specifies a latitude and longitude.
	Example: GEO:geo:39.95,-75.1667
  */
  function setGeo($input)
    {
    $this->geo = (string) $input;
    } // end function

 /**
  * Set impp
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  	Defines an instant messenger handle.
	Example: IMPP:aim:johndoe@aol.com
  */
  function setImpp($input)
    {
    $this->impp = (string) $input;
    } // end function
	
   /**
  * Set Key
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  	The public encryption key associated with the vCard object. It may point to an external URL, may be plain text, or may be embedded in the vCard as a Base64 encoded block of text.
	Example: KEY:data:application/pgp-keys;base64,[base64-data]
  */
  function setKey($input)
    {
    $this->varkey = (string) $input;
    } // end function
	  
	/**
  * Set Logo
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  	An image or graphic of the logo of the organization that is associated with the individual to which the vCard belongs. It may point to an external URL or may be embedded in the vCard as a Base64 encoded block of text.
	Example: data:image/png;base64,[base64-data]
  */
  function setLogo($input)
    {
    $this->logo = (string) $input;
    } // end function
	
	
	/**
  * Set Member
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  	Defines a member that is part of the group that this vCard represents. Acceptable values include:
a "mailto:" URL containing an email address a UID which references the member's own vCard
	The KIND property must be set to "group" in order to use this property.
	Example: MEMBER:urn:uuid:03a0e51f-d1aa-4385-8a53-e29025acd8af
  */
  function setMember($input)
    {
    $this->member = (string) $input;
    } // end function
	
	/**
  * Set Photo
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  	An image or photograph of the individual associated with the vCard. It may point to an external URL or may be embedded in the vCard as a Base64 encoded block of text.
	Example: PHOTO:data:image/jpeg;base64,[base64-data]
  */
  function setPhoto($input)
    {
    $this->photo = (string) $input;
    } // end function
	
	/**
  * Set Prodid
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  	The identifier for the product that created the vCard object.
	Example: PRODID:-//ONLINE DIRECTORY//NONSGML Version 1//EN
  */
  function setProdid($input)
    {
    $this->prodid = (string) $input;
    } // end function
  
  
	/**
  * Set Related
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  	Another entity that the person is related to. Acceptable values include:
a "mailto:" URL containing an email address
a UID which references the person's own vCard
	Example: RELATED;TYPE=friend:urn:uuid:03a0e51f-d1aa-4385-8a53-e29025acd8af
  */
  function setRelated($input)
    {
    $this->related = (string) $input;
    } // end function
	
	/**
  * Set Sound
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  	By default, if this property is not grouped with other properties it specifies the pronunciation of the FN property of the vCard object. It may point to an external URL or may be embedded in the vCard as a Base64 encoded block of text.
	Example: SOUND:data:audio/ogg;base64,[base64-data]
  */
  function setSound($input)
    {
    $this->sound = (string) $input;
    } // end function


/**
  * Set Source
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  	A URL that can be used to get the latest version of this vCard.
	Example: SOURCE:http://johndoe.com/vcard.vcf
  */
  function setSource($input)
    {
    $this->source = (string) $input;
    } // end function
	
	
	/**
  * Set Tz
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  	The time zone of the vCard object.
	Example: TZ:America/New_York
  */
  function setTz($input)
    {
    $this->tz = (string) $input;
    } // end function
	
	
	/**
  * Set Uid
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  	Specifies a value that represents a persistent, globally unique identifier associated with the object.
	Example: UID:urn:uuid:da418720-3754-4631-a169-db89a02b831b
  */
  function setUid($input)
    {
    $this->uid = (string) $input;
    } // end function
	
	/**
  * Set Xml
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  	Any XML data that is attached to the vCard. This is used if the vCard was encoded in XML (xCard standard) and the XML document contained elements which are not part of the xCard standard.
	Example: XML:<b>Not an xCard XML element</b>
  */
  function setXml($input)
    {
    $this->xml = (string) $input;
    } // end function
	
		/**
  * Set Kind
  *
  * @param (string) $input
  * @return (void)
  * @access public
  * @since 1.000 - 2002/10/20  
  	Defines the type of entity that this vCard represents, such as an individual or organization.
	Example: KIND:individual
  */
  function setKind($input)
    {
    $this->kind = (string) $input;
    } // end function
	  
	  
  /**
  * Generates the string to be written in the file later on
  *
  * @return (void)
  * @see getCardOutput(), writeCardFile()
  * @access public
  * @since 1.000 - 2002/10/10   
  */
  function generateCardOutput()
    {
    $this->output  = (string) "BEGIN:VCARD\r\n";
    $this->output .= (string) "VERSION:2.1\r\n";
    $this->output .= (string) "N;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($this->last_name . ";" . $this->first_name . ";" . $this->middle_name . ";" . $this->addon) . "\r\n";
    $this->output .= (string) "FN;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($this->first_name . " " . $this->middle_name . " " . $this->last_name . " " . $this->addon) . "\r\n";
    
    if (strlen(trim($this->nickname)) > 0)
      {    
      $this->output .= (string) "NICKNAME;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($this->nickname) . "\r\n";
      } // end if
	if (strlen(trim($this->sortstring)) > 0)
      {    
      $this->output .= (string) "SORT-STRING:" . $this->quotedPrintableEncode($this->sortstring) . "\r\n";
      } // end if
	
    $this->output .= (string) "ORG" . $this->lang . ";ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($this->organisation) . ";" . $this->quotedPrintableEncode($this->department) . "\r\n";
    
    if (strlen(trim($this->job_title)) > 0)
      {
      $this->output .= (string) "TITLE" . $this->lang . ";ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($this->job_title) . "\r\n";
      } // end if
    
    if (strlen(trim($this->note)) > 0)
      {
      $this->output .= (string) "NOTE" . $this->lang . ";ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($this->note) . "\r\n";
      } // end if

    if (strlen(trim($this->tel_work1_voice)) > 0)
      {
      $this->output .= (string) "TEL;WORK;VOICE:" . $this->tel_work1_voice . "\r\n";
      } // end if
    
    if (strlen(trim($this->tel_work2_voice)) > 0)
      {
      $this->output .= (string) "TEL;WORK;VOICE:" . $this->tel_work2_voice . "\r\n";
      } // end if
    
    if (strlen(trim($this->tel_home1_voice)) > 0)
      {
      $this->output .= (string) "TEL;HOME;VOICE:" . $this->tel_home1_voice . "\r\n";
      } // end if
	  
    if (strlen(trim($this->tel_cell_voice)) > 0)
      {
      $this->output .= (string) "TEL;CELL;VOICE:" . $this->tel_cell_voice . "\r\n";
      } // end if

    if (strlen(trim($this->tel_car_voice)) > 0)
      {
      $this->output .= (string) "TEL;CAR;VOICE:" . $this->tel_car_voice . "\r\n";
      } // end if

    if (strlen(trim($this->tel_additional)) > 0)
      {
      $this->output .= (string) "TEL;VOICE:" . $this->tel_additional . "\r\n";
      } // end if

    if (strlen(trim($this->tel_pager_voice)) > 0)
      {
      $this->output .= (string) "TEL;PAGER;VOICE:" . $this->tel_pager_voice . "\r\n";
      } // end if
      
    if (strlen(trim($this->tel_work_fax)) > 0)
      {
      $this->output .= (string) "TEL;WORK;FAX:" . $this->tel_work_fax . "\r\n";
      } // end if

    if (strlen(trim($this->tel_home_fax)) > 0)
      {
      $this->output .= (string) "TEL;HOME;FAX:" . $this->tel_home_fax . "\r\n";
      } // end if

    if (strlen(trim($this->tel_home2_voice)) > 0)
      {
      $this->output .= (string) "TEL;HOME:" . $this->tel_home2_voice . "\r\n";
      } // end if

    if (strlen(trim($this->tel_isdn)) > 0)
      {
      $this->output .= (string) "TEL;ISDN:" . $this->tel_isdn . "\r\n";
      } // end if
      
    if (strlen(trim($this->tel_preferred)) > 0)
      {
      $this->output .= (string) "TEL;PREF:" . $this->tel_preferred . "\r\n";
      } // end if      
	if((strlen(trim($this->company)) > 0)||(strlen(trim($this->work_street)) > 0)||(strlen(trim($this->work_city)) > 0)||(strlen(trim($this->work_region)) > 0)||(strlen(trim($this->work_zip)) > 0)||(strlen(trim($this->work_country)) > 0)){
			$this->output .= (string) "ADR;WORK:;" . $this->company . ";" . $this->work_street . ";" . $this->work_city . ";" . $this->work_region . ";" . $this->work_zip . ";" . $this->work_country . "\r\n";
			$this->output .= (string) "LABEL;WORK;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($this->company) . "=0D=0A" . $this->quotedPrintableEncode($this->work_street) . "=0D=0A" . $this->quotedPrintableEncode($this->work_city) . ", " . $this->quotedPrintableEncode($this->work_region) . " " . $this->quotedPrintableEncode($this->work_zip) . "=0D=0A" . $this->quotedPrintableEncode($this->work_country) . "\r\n";
	}
	
	if((strlen(trim($this->home_street)) > 0)||(strlen(trim($this->home_city)) > 0)||(strlen(trim($this->home_region)) > 0)||(strlen(trim($this->home_zip)) > 0)||(strlen(trim($this->home_country)) > 0)){
		$this->output .= (string) "ADR;HOME:;;" . $this->home_street . ";" . $this->home_city . ";" . $this->home_region . ";" . $this->home_zip . ";" . $this->home_country . "\r\n";
		$this->output .= (string) "LABEL;WORK;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($this->home_street) . "=0D=0A" . $this->quotedPrintableEncode($this->home_city) . ", " . $this->quotedPrintableEncode($this->home_region) . " " . $this->quotedPrintableEncode($this->home_zip) . "=0D=0A" . $this->quotedPrintableEncode($this->home_country) . "\r\n";
	}
	
	if((strlen(trim($this->postal_street)) > 0)||(strlen(trim($this->postal_city)) > 0)||(strlen(trim($this->postal_region)) > 0)||(strlen(trim($this->postal_zip)) > 0)||(strlen(trim($this->postal_country)) > 0)){
		$this->output .= (string) "ADR;POSTAL:;;" . $this->postal_street . ";" . $this->postal_city . ";" . $this->postal_region . ";" . $this->postal_zip . ";" . $this->postal_country . "\r\n";
		$this->output .= (string) "LABEL;POSTAL;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($this->postal_street) . "=0D=0A" . $this->quotedPrintableEncode($this->postal_city) . ", " . $this->quotedPrintableEncode($this->postal_region) . " " . $this->quotedPrintableEncode($this->postal_zip) . "=0D=0A" . $this->quotedPrintableEncode($this->postal_country) . "\r\n";
	}
    if (strlen(trim($this->url_work)) > 0)
      {
      $this->output .= (string) "URL;WORK:" . $this->url_work . "\r\n";
      } // end if  
	if (strlen(trim($this->url_home)) > 0)
      {
      $this->output .= (string) "URL;HOME:" . $this->url_home . "\r\n";
      } // end if  
	 
	 if (strlen(trim($this->caladruri)) > 0)
      {
      $this->output .= (string) "CALADRURI:" . $this->caladruri . "\r\n";
      } // end if
	  
	 if (strlen(trim($this->categories)) > 0)
      {
      $this->output .= (string) "CATEGORIES:" . $this->categories . "\r\n";
      } // end if
	 if (strlen(trim($this->clientpidmap)) > 0)
      {
      $this->output .= (string) "CLIENTPIDMAP:" . $this->clientpidmap . "\r\n";
      } // end if
	  
	 if (strlen(trim($this->fburl)) > 0)
      {
      $this->output .= (string) "FBURL:" . $this->fburl . "\r\n";
      } // end if
	  
	 if (strlen(trim($this->gender)) > 0)
      {
      $this->output .= (string) "GENDER:" . $this->gender . "\r\n";
      } // end if

	 if (strlen(trim($this->impp)) > 0)
      {
      $this->output .= (string) "IMPP:" . $this->impp . "\r\n";
      } // end if
	  
	 if (strlen(trim($this->caluri)) > 0)
      {
      $this->output .= (string) "CALURI:" . $this->caluri . "\r\n";
      } // end if      

    if (strlen(trim($this->role)) > 0)
      {
      $this->output .= (string) "ROLE" . $this->lang . ":" . $this->role . "\r\n";
      } // end if  
    
    if (strlen(trim($this->birthday)) > 0)
      {
      $this->output .= (string) "BDAY:" . $this->birthday . "\r\n";
      } // end if 
	  
	if (strlen(trim($this->anniversary)) > 0)
      {
      $this->output .= (string) "ANNIVERSARY:" . $this->anniversary . "\r\n";
      } // end if 
	  
	if (strlen(trim($this->kind)) > 0)
      {
      $this->output .= (string) "KIND:" . $this->kind . "\r\n";
      } // end if 
	if (strlen(trim($this->logo)) > 0)
      {
      $this->output .= (string) "LOGO:" . $this->logo . "\r\n";
      } // end if 
	  
	if (strlen(trim($this->member)) > 0)
      {
      $this->output .= (string) "MEMBER:" . $this->member . "\r\n";
      } // end if 
	  
	if (strlen(trim($this->photo)) > 0)
      {
      $this->output .= (string) "PHOTO:" . $this->photo . "\r\n";
      } // end if 
	if (strlen(trim($this->prodid)) > 0)
      {
      $this->output .= (string) "PRODID:" . $this->prodid . "\r\n";
      } // end if 
	  
	if (strlen(trim($this->related)) > 0)
      {
      $this->output .= (string) "RELATED:" . $this->related . "\r\n";
      } // end if 
	  
	if (strlen(trim($this->sound)) > 0)
      {
      $this->output .= (string) "SOUND:" . $this->sound . "\r\n";
      } // end if 
	  
	if (strlen(trim($this->source)) > 0)
      {
      $this->output .= (string) "SOURCE:" . $this->source . "\r\n";
      } // end if 

	if (strlen(trim($this->tz)) > 0)
      {
      $this->output .= (string) "TZ:" . $this->tz . "\r\n";
      } // end if 

	if (strlen(trim($this->uid)) > 0)
      {
      $this->output .= (string) "UID:" . $this->uid . "\r\n";
      } // end if 
	
	if (strlen(trim($this->xml)) > 0)
      {
      $this->output .= (string) "XML:" . $this->xml . "\r\n";
      } // end if
	
	if (strlen(trim($this->geo)) > 0)
      {
      $this->output .= (string) "GEO:" . $this->geo . "\r\n";
      } // end if  
    
    if (count(($this->email)) > 0)
      {
		  //scorro tutte le email analizzate
		  for($count=0;$count<count($this->email);$count++){
			  if($count==0){
			  	//la prima email analizzata sarà la predefinita
		  	  	$this->output .= (string) "EMAIL;PREF;INTERNET:" . $this->email[$count] . "\r\n";
			  }else{
      		  	$this->output .= (string) "EMAIL;INTERNET:" . $this->email[$count] . "\r\n";
			  }
		  }
      } // end if 
	  
	  if (count(($this->url)) > 0)
      {
		  //scorro tutte le email analizzate
		  for($count=0;$count<count($this->url);$count++){
		  	  $this->output .= (string) "URL:" . $this->url[$count] . "\r\n";
		  }
      } // end if 
	
    if (strlen(trim($this->mailer)) > 0)
      {    
      $this->output .= (string) "MAILER:" . $this->quotedPrintableEncode($this->mailer) . "\r\n";
      } // end if
	  
    if (strlen(trim($this->varkey)) > 0)
      {    
      $this->output .= (string) "KEY:" . $this->quotedPrintableEncode($this->varkey) . "\r\n";
      } // end if
	  
	  
	  
	  
	  
    $this->output .= (string) "REV:" . $this->rev . "\r\n";
    $this->output .= (string) "END:VCARD\r\n";
    } // end function  
	
	
  function Add_newsletter_import_group($user_id){
	return $this->mysql_database->Add_newsletter_import_group($user_id);
  }
	/**
  * Salva la vcard nel database come riga della tabella user_newsletter
  *
  * @return (void)
  * @see getCardOutput(), writeCardFile()
  * @access public
  * @since 1.000 - 2002/10/10   
  */
  function storeinDB($user_id,$id_group)
    {
		
		$fn = $this->quotedPrintableEncode($this->first_name . " " . $this->middle_name . " " . $this->last_name . " " . $this->addon);
		$inserted_id = $this->mysql_database->Store_vcard($this->first_name , $this->last_name, $this->middle_name, $this->addon, $fn, $this->nickname, $this->sortstring, $this->organisation, $this->department, $this->job_title, $this->note,$this->url_home,$this->url_work, $this->tel_home1_voice, $this->tel_home2_voice, $this->tel_work1_voice, $this->tel_work2_voice, $this->tel_car_voice, $this->tel_additional, $this->tel_pager_voice, $this->tel_home_fax, $this->tel_work_fax, $this->tel_isdn, $this->tel_preferred, $this->company, $this->work_street,$this->work_city, $this->work_region, $this->work_zip, $this->work_country, $this->home_street, $this->home_city,$this->home_region, $this->home_zip, $this->home_country, $this->postal_street, $this->postal_city,$this->postal_region, $this->postal_zip,$this->postal_country, $this->role, $this->birthday, $this->mailer,$this->tel_cell_voice,$this->varkey, $this->anniversary, $this->caladruri, $this->caluri, $this->categories, $this->clientpidmap, $this->fburl, $this->gender, $this->geo, $this->impp, $this->kind, $this->logo, $this->member, $this->photo, $this->prodid, $this->related, $this->sound, $this->source, $this->tz, $this->uid, $this->xml, $id_group, $user_id);
		for($i=0;$i<count($this->email);$i++){
			if($i==0)
				$this->mysql_database->Store_vcard_emails($user_id,$id_group,$inserted_id,$this->email[$i],1);
			else
				$this->mysql_database->Store_vcard_emails($user_id,$id_group,$inserted_id,$this->email[$i],0);
		}
		
		for($i=0;$i<count($this->url);$i++){
			if($i==0)
				$this->mysql_database->Store_vcard_url($user_id,$id_group,$inserted_id,$this->url[$i],1);
			else
				$this->mysql_database->Store_vcard_url($user_id,$id_group,$inserted_id,$this->url[$i],0);
		}
    } // end function  
	
	
	
	
	
  
  /**
  * Loads the string into the variable if it hasn't been set before
  *
  * @return (string) $output
  * @see generateCardOutput(), writeCardFile()
  * @access public
  * @since 1.000 - 2002/10/10   
  */
  function getCardOutput()
    {
    if (!isset($this->output))
      {
      $this->generateCardOutput();
      } // end if
    return (string) $this->output;
    } // end function  
  
  /**
  * Writes the string into the file and saves it to the download directory
  *
  * @return (void)
  * @see generateCardOutput(), getCardOutput()
  * @access public
  * @since 1.000 - 2002/10/10   
  */
  function writeCardFile()
    {
    if (!isset($this->output))
      {
      $this->generateCardOutput();
      } // end if
    $handle = fopen($this->download_dir . '/' . $this->card_filename, 'w');
    fputs($handle, $this->output);
    fclose($handle);
    $this->deleteOldFiles(30);
    if (isset($handle)) { unset($handle); }
    } // end function      
  
  /**
  * Writes the string into the file and saves it to the download directory
  *
  * @param (int) $time  Minimum age of the files (in seconds) before files get deleted
  * @return (void)
  * @see writeCardFile()
  * @access private
  * @since 1.000 - 2002/10/20   
  */
  function deleteOldFiles($time = 300)
    {
    if (!is_int($time) || $time < 1)
      {
      $time = (int) 300;
      } // end if
    $handle = opendir($this->download_dir);
    while ($file = readdir($handle))
      {
      if (!eregi("^\.{1,2}$",$file) && !is_dir($this->download_dir . '/' . $file) && eregi("\.vcf",$file) && ((time() - filemtime($this->download_dir . '/' . $file)) > $time))
        {
        unlink($this->download_dir . '/' . $file);
        } // end if
      } // end while
    closedir($handle);
    if (isset($handle)) { unset($handle); } 
    if (isset($file)) { unset($file); } 
    } // end function        
  
  /**
  * Returns the full path to the saved file where it can be downloaded.
  *
  * Can be used for "header(Location:..."
  *
  * @return (string)  Full http path
  * @access public
  * @since 1.000 - 2002/10/20   
  */
  function getCardFilePath()
    {
    $path_parts = pathinfo($_SERVER['SCRIPT_NAME']);
    $port = (string) (($_SERVER['SERVER_PORT'] != 80) ? ':' . $_SERVER['SERVER_PORT'] : '' );
    return (string) 'http://' . $_SERVER['SERVER_NAME'] . $port . $path_parts["dirname"] . '/' . $this->download_dir . '/' . $this->card_filename;
    } // end function 
  /**
  * Returns the file name of the vcard.
  *
  * Can be used for "header(Location:..."
  *
  * @return (string)  Full http path
  * @access public
  * @since 1.000 - 2002/10/20   
  */
  	 function getCardFileName()
    {
    	return (string) $this->card_filename;
    } // end function    
  } // end class vCard
?>
