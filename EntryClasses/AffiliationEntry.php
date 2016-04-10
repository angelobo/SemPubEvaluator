<?php

class AffiliationEntry extends Entry{
	
	public function getAffiliationIRI(){
		return trim($this->getData()[0]);		
	}
	
	public function getAffiliationFullname(){
		return trim($this->getData()[1]);
	}
	
	public function getAuthorIRI(){
		return trim($this->getData()[2]);
	}
	
	public function getAuthorFullname(){
		return trim($this->getData()[3]);
	}
	
	public function getNormalizedAuthorFullname(){
		$nn = $this->getAuthorFullname();
		
		$charactersSubstitutionMap = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
				'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
				'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
				'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
				'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' ,
					
				'ā' => 'a', 'č' => 'c', 'ü' => 'u', 'Ş' => 'S', 'ş' => 's', 'ř' => 'r', 'ć' => 'c', 'ě' => 'e', 'ı' => 'i');
		
		$nn = strtr( $nn, $charactersSubstitutionMap);
		
		$nn = preg_replace("/[^a-zA-Z]+/", "", $nn);
		
		return strtolower($nn);
	}
	
	public function getNormalizedAffiliationFullname(){
		$nn = $this->getAffiliationFullname();
		
		$nn = preg_replace("/[^a-zA-Z]+/", "", $nn);
	
		return strtolower($nn);
	}
		
	public function renderAsHTMLTableRow(){
		
		$valuesInRow = array();
		
		$valuesInRow[] = htmlentities($this->getAffiliationIRI());
		$valuesInRow[] = $this->getAffiliationFullname();
		$valuesInRow[] = htmlentities($this->getAuthorIRI());
		$valuesInRow[] = $this->getAuthorFullname();
		
		$tableRow = $this->renderDataAsHTMLTableRow($valuesInRow);
		
		return $tableRow;
		
	}

	/***
	 *
	* MATCHING RULES:
	*
	* [Strict]: same normalized affiliation and author name (as they appear in the header of the paper)
	* [Loose]: part of the affiliation (and author) matches
	*/
	public function matchesEntry($searchEntry, $evaluationLevel){
	
		$matchingEntry = FALSE;
	
		if ($evaluationLevel == "loose"){
			
			if (
			((!(strpos( $this->getNormalizedAffiliationFullname(), $searchEntry->getNormalizedAffiliationFullname()) === FALSE )) ||  
			(!(strpos(  $searchEntry->getNormalizedAffiliationFullname(), $this->getNormalizedAffiliationFullname()) === FALSE )))
			&&
			($this->getNormalizedAuthorFullname() == $searchEntry->getNormalizedAuthorFullname())
			)
			$matchingEntry = TRUE;
		}
		else {
			if (			
			($this->getNormalizedAffiliationFullname() == $searchEntry->getNormalizedAffiliationFullname())  &&
			($this->getNormalizedAuthorFullname() == $searchEntry->getNormalizedAuthorFullname())
			)
			$matchingEntry = TRUE;
		}
		
		return $matchingEntry;
	}
}


?>