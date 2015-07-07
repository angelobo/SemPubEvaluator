<?php

class GrantEntry extends Entry{
	
	public function getGrantIRI(){
		return trim($this->getData()[0]);		
	}

	public function getGrantIdentifier(){
		return trim($this->getData()[1]);
	}
	
	public function getGrantName(){
		return trim($this->getData()[2]);
	}
	
	public function getNormalizedGrantIdentifier(){
		
		$ng = $this->getGrantIdentifier();
		$ng = preg_replace("/[^a-zA-Z0-9]+/", "", $ng);
			
		return strtolower($ng);
	}
	
		
	public function renderAsHTMLTableRow(){
		
		$valuesInRow = array();
		
		$valuesInRow[] = htmlentities($this->getGrantIRI());
		$valuesInRow[] = $this->getGrantIdentifier();
		$valuesInRow[] = $this->getGrantName();
		
		$tableRow = $this->renderDataAsHTMLTableRow($valuesInRow);
		
		return $tableRow;
		
	}

	/***
	 * 
	 * MATCHING RULES:
	 * 
	 * [Strict]: equal grant identifier
	 * 
	 * [Loose]:grant identifies are normalized as follows:
	 * 			- only characters and numbers are considered
	 * 			- cases like "n. <grantnumber>", "n¡ <grantnumber>" are considered correct too
	 *
	 */
	public function matchesEntry($searchEntry, $evaluationLevel){
	
		$matchingEntry = FALSE;
		
		if ($evaluationLevel == "loose"){
			if  (
				($this->getNormalizedGrantIdentifier() == $searchEntry->getNormalizedGrantIdentifier()) ||
				($this->getNormalizedGrantIdentifier() == ("n".$searchEntry->getNormalizedGrantIdentifier()))
				)	
			$matchingEntry = TRUE;
		}
		else {
			if ($this->getGrantIdentifier() == $searchEntry->getGrantIdentifier())
				$matchingEntry = TRUE;
		}
		
		return $matchingEntry;
	}
}

?>