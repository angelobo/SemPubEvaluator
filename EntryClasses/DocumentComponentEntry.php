<?php

class DocumentComponentEntry extends Entry{
	
	public function getResourceIri(){
		return trim($this->getData()[0]);		
	}
	
	public function getObjectNumber(){
		
		return trim($this->getData()[1]);
	}
	
	public function getNormalizedObjectNumber(){
	
		$number = $this->getObjectNumber();
	
		$datatypePos = strpos($number, "^^xsd:integer");
	
		if ($datatypePos > 0)
			$number = substr($number, 0,$datatypePos);
	
		return $number;
	}
	
	public function getTitleOrCaption(){
		return trim($this->getData()[2]);	
	}
	
	
	public function getNormalizedTitleOrCaption(){
		$nt = $this->getTitleOrCaption();
		$nt = preg_replace("/\s&\s/", " and ", $nt);
		$nt = preg_replace("/[^a-zA-Z0-9]+/", "", $nt);
		
		return strtolower($nt);
	}
	
	
	public function getShortenedTitleOrCaption($length = 50){
		$content = $this->getTitleOrCaption();
		
		if (strlen($content) > $length)
			$contentDisplayed = substr($content, 0, $length)." ...";
		else
			$contentDisplayed = $content;
		
		return $contentDisplayed;
	}


	/***
	 * 
	 * MATCHING RULES:
	 * 
	 * [Strict/Loose]: 
	 * 		- normalized titles are equal
	 * 		- same object number - datatype (xsd:anyURI) is not taken into account
	 * 
	 */
	public function matchesEntry($searchEntry, $evaluationLevel){
	
		$matchingEntry = FALSE;
	
		if (
			(($this->getNormalizedObjectNumber() == $searchEntry->getNormalizedObjectNumber()))  &&
			($this->getNormalizedTitleOrCaption() == $searchEntry->getNormalizedTitleOrCaption())
			)
		$matchingEntry = TRUE;
	
		return $matchingEntry;
	}

	
	public function renderAsHTMLTableRow(){
		
		$valuesToDisplay = array();
		
		$valuesToDisplay[] = htmlspecialchars($this->getResourceIri());
		$valuesToDisplay[] = $this->getObjectNumber();
		$valuesToDisplay[] = $this->getShortenedTitleOrCaption(50);
		
		$tableRow = $this->renderDataAsHTMLTableRow($valuesToDisplay);
		
		return $tableRow;
		
	}
	
	
	
}


?>