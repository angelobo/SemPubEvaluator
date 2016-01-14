<?php

class URLEntry extends Entry{
	
	public function getURL(){
		return trim($this->getData()[0]);		
	}

	public function getNormalizedURL(){
		
		$url = $this->getURL();
		
		$datatypePos = strpos($url, "^^xsd:anyURI");
		
		if ($datatypePos > 0)
			$url = substr($url, 0,$datatypePos);
		
		return $url;
	}
	
	
	public function renderAsHTMLTableRow(){
		
		$valuesInRow = array();
		
		$valuesInRow[] = htmlentities($this->getURL());
		
		$tableRow = $this->renderDataAsHTMLTableRow($valuesInRow);
		
		return $tableRow;
		
	}

	/***
	 * 
	 * MATCHING RULES:
	 * 
	 * [Strict/Loose]: URL  must be equal, datatype (xsd:anyURI) is not taken into account
	 *
	 */
	public function matchesEntry($searchEntry, $evaluationLevel){
	
		$matchingEntry = FALSE;
	
		if (($this->getNormalizedURL() == $searchEntry->getNormalizedURL())) 
			$matchingEntry = TRUE;

		return $matchingEntry;
	}
}


?>