<?php

class FootnoteEntry extends Entry{
	
	public function getResourceIri(){
		return trim($this->getData()[0]);		
	}
	
	public function getFoonoteMarker(){
		
		return trim($this->getData()[1]);
	}
	
	public function getNormalizedFoonoteMarker(){
	
		$number = $this->getFoonoteMarker();
	
		$datatypePos = strpos($number, "^^xsd:integer");
	
		if ($datatypePos > 0)
			$number = substr($number, 0,$datatypePos);
	
		return $number;
	}
	
	public function getFootnoteBody(){
		return trim($this->getData()[2]);	
	}
	
	
	public function getNormalizedFootnoteBody(){
		$nt = $this->getFootnoteBody();
		$nt = preg_replace("/\s&\s/", " and ", $nt);
		$nt = preg_replace("/(\s)+/", " ", $nt);
		$nt = preg_replace("/[^a-zA-Z0-9\s]+/", "", $nt);
		
		return strtolower($nt);
	}
	
	
	public function getShortenedFootnoteBody($length = 50){
		$content = $this->getFootnoteBody();
		
		if (strlen($content) > $length)
			$contentDisplayed = substr($content, 0, $length)." ...";
		else
			$contentDisplayed = $content;
		
		return $contentDisplayed;
	}


	public function getSentenceWithFootnote(){
		return trim($this->getData()[3]);
	}
	
	
	public function getNormalizedSentenceWithFootnote(){
		$nt = $this->getSentenceWithFootnote();
		$nt = preg_replace("/\s&\s/", " and ", $nt);
		$nt = preg_replace("/(\s)+/", " ", $nt);
		$nt = preg_replace("/[^a-zA-Z0-9\s]+/", "", $nt);
	
		return strtolower($nt);
	}
	
	
	public function getShortenedSentenceWithFootnote($length = 50){
		$content = $this->getSentenceWithFootnote();
	
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
	 * 		- titles are normalized: lowercase, multiple white spaces are collapsed in single one
	 * 		- normalized titles are equal including spaces
	 * 		- same object number, datatype (xsd:integer) is not taken into account in the number
	 * 		- prepositions "and" and "&" are considered equal
	 * 
	 */
	public function matchesEntry($searchEntry, $evaluationLevel){
	
		$matchingEntry = FALSE;
	
		if (
			(($this->getNormalizedFoonoteMarker() == $searchEntry->getNormalizedFoonoteMarker()))  &&
			($this->getNormalizedFootnoteBody() == $searchEntry->getNormalizedFootnoteBody())   &&
			($this->getNormalizedSentenceWithFootnote() == $searchEntry->getNormalizedSentenceWithFootnote())
			)
		$matchingEntry = TRUE;
	
		return $matchingEntry;
	}

	
	public function renderAsHTMLTableRow(){
		
		$valuesToDisplay = array();
		
		$valuesToDisplay[] = htmlspecialchars($this->getResourceIri());
		$valuesToDisplay[] = $this->getFoonoteMarker();
		$valuesToDisplay[] = $this->getShortenedFootnoteBody(50);
		$valuesToDisplay[] = $this->getShortenedSentenceWithFootnote(50);
		
		$tableRow = $this->renderDataAsHTMLTableRow($valuesToDisplay);
		
		return $tableRow;
		
	}
	
	
	
}


?>