<?php

class OntologyEntry extends Entry{
	
	public function getOntologyIRI(){
		return trim($this->getData()[0]);		
	}

	public function getOntologyName(){
		return trim($this->getData()[1]);
	}

	public function getNormalizedOntologyName(){
		
		$no = $this->getNormalizedOntologyFullname();
		$no = preg_replace("/\(.*\)/", "", $no);
		
		return trim($no);
	}
	
	public function getOntologyAcronym(){
		$no = $this->getNormalizedOntologyFullname();
		
		$acronymFound = preg_match("/(.*)\((.*)\)/", $no, $matches);
		
		if ($acronymFound == 1)
			$no = trim($matches[2]);

		return trim($no);
		
	}
	
	public function getNormalizedOntologyFullname(){
		$no = $this->getOntologyName();
		$no = strtolower($no);
		$no = preg_replace("/\sontology/", "", $no);
		$no = preg_replace("/_/", " ", $no);
		
		return trim($no);
	}
	
	
	public function renderAsHTMLTableRow(){
		
		$valuesInRow = array();
		
		$valuesInRow[] = htmlentities($this->getOntologyIRI());
		$valuesInRow[] = $this->getOntologyName();
		
		$tableRow = $this->renderDataAsHTMLTableRow($valuesInRow);
		
		return $tableRow;
		
	}

	/***
	 * 
	 * MATCHING RULES:
	 * 
	 * [Strict/Loose]: -equal ontology name
	 * 			 - the word 'ontology' is stripped off
	 *  		 - acronyms in () brackets are considered valid too  	
	 *
	 */
	public function matchesEntry($searchEntry, $evaluationLevel){
	
		$matchingEntry = FALSE;
	
		if (($this->getNormalizedOntologyName() == $searchEntry->getNormalizedOntologyName()) ||
			($this->getOntologyAcronym() == $searchEntry->getOntologyAcronym() )
			) 
			$matchingEntry = TRUE;

		return $matchingEntry;
	}
}


?>