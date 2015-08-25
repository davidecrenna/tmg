<?php


class PDF_biglietto extends FPDI { 
   /**
     * "Remembers" the template id of the imported page
     */
    var $_tplIdx; 
	var $path_blank = 'tmgbv2012.pdf';
	
	/**
 	* include a background template for every page
	*/ 
    function Header() { 
        if (is_null($this->_tplIdx)) { 
			$this->setSourceFile($this->path_blank);
            $this->_tplIdx = $this->importPage(1); 
        } 
        $this->useTemplate($this->_tplIdx); 
        
    }
	function Footer() {} 
}

class PDF_storia extends FPDI { 
   /**
     * "Remembers" the template id of the imported page
     */
    var $_tplIdx; 
	/*var $path_blank = 'storia_blank.pdf';
	
	
 	// include a background template for every page
    
	
	function Header() { 
        if (is_null($this->_tplIdx)) { 
			$this->setSourceFile($this->path_blank);
            $this->_tplIdx = $this->importPage(1); 
        } 
        $this->useTemplate($this->_tplIdx); 
        
    }*/
	function Footer() {} 
}



class PDF_curriculum extends FPDI { 
   /**
     * "Remembers" the template id of the imported page
     */
    var $_tplIdx; 
	/**
 	* include a background template for every page
	*/ 
   /*function Header() { 
        if (is_null($this->_tplIdx)) { 
            $this->setSourceFile('curriculum_blank.pdf'); 
            $this->_tplIdx = $this->importPage(1); 
        } 
        $this->useTemplate($this->_tplIdx); 
        
    }*/
	function Footer() {} 
} 
?>