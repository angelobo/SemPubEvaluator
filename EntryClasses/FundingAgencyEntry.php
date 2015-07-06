<?php

class FundingAgencyEntry extends Entry{
	
	public function getFundingAgencyIRI(){
		return trim($this->getData()[0]);		
	}

	public function getFundingAgencyName(){
		$nf = trim($this->getData()[1]);
		$nf = preg_replace("/^the /", "", $nf);
		return $nf;
	}
	
	
	public function getNormalizedFundingAgencyName(){
	
		$nf = $this->getFundingAgencyName();
		$nf = preg_replace("/^the /", "", $nf);
		$nf = preg_replace("/_/", " ", $nf);
		$nf = preg_replace("/[^a-zA-Z0-9]+/", "", $nf);
			
		return strtolower($nf);
	}
	
		
	public function renderAsHTMLTableRow(){
		
		$valuesInRow = array();
		
		$valuesInRow[] = htmlentities($this->getFundingAgencyIRI());
		$valuesInRow[] = $this->getFundingAgencyName();
		
		$tableRow = $this->renderDataAsHTMLTableRow($valuesInRow);
		
		return $tableRow;
		
	}

	/***
	 * 
	 * MATCHING RULES:
	 * 
	 * [Strict/Loose]: 
	 * 			- equal FundingAgency name
	 * 			- acronym in () brackets is considered valid too  	
	 *
	 */
	public function matchesEntry($searchEntry, $evaluationLevel){
	
		$matchingEntry = FALSE;
	
		if ($evaluationLevel == "loose"){
			if ($this->getNormalizedFundingAgencyName() == $searchEntry->getNormalizedFundingAgencyName())
			$matchingEntry = TRUE;
		}
		else {
			if ($this->getFundingAgencyName() == $searchEntry->getFundingAgencyName())
			$matchingEntry = TRUE;
		}
		
		return $matchingEntry;
	}
}


?>