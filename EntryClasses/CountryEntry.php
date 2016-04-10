<?php

class CountryEntry extends Entry{
	
	public function getCountryIRI(){
		return trim($this->getData()[0]);		
	}

	public function getCountryName(){
		return trim($this->getData()[1]);
	}

	public function getNormalizedCountryName(){
		
		$no = $this->getCountryName();
		$no = strtolower($no);
		
		if (substr($no, 0, 4) == "the ")
			$no = substr($no, 4);
		
		switch ($no) {
			case "united states of america":
			case "u.s.a.":
			$no = "usa";
			break;
			case "united kingdom":
			case "u.k.":
				$no = "uk";
				break;
		}
		
		return trim($no);
	}
		
	
	public function renderAsHTMLTableRow(){
		
		$valuesInRow = array();
		
		$valuesInRow[] = htmlentities($this->getCountryIRI());
		$valuesInRow[] = $this->getCountryName();
		
		$tableRow = $this->renderDataAsHTMLTableRow($valuesInRow);
		
		return $tableRow;
		
	}

	/***
	 * 
	 * MATCHING RULES:
	 * 
	 * [Strict/Loose]: Country names must be equal after some normalization:
	 * 			 - names are transformed in lowercase 
	 *			 - some country names are normalized: u.s.a., UK 	
	 */
	public function matchesEntry($searchEntry, $evaluationLevel){
	
		$matchingEntry = FALSE;
	
		if (($this->getNormalizedCountryName() == $searchEntry->getNormalizedCountryName())) 
			$matchingEntry = TRUE;

		return $matchingEntry;
	}
}


?>