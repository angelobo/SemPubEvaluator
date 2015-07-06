<?php

class CEURArticleEntry extends ArticleEntry{
	
	/***
	 * 
	 * MATCHING RULES:
	 * 
	 * [Strict/Loose]: match paper URIs (that have to follow challenge rules)
	 *
	 */
	public function matchesEntry($searchEntry, $evaluationLevel){
	
		$matchingEntry = FALSE;
	
		if 	(
				( $this->getResourceIri() == $searchEntry->getResourceIri() ) || 
				( "<".$this->getResourceIri().">" == $searchEntry->getResourceIri() )
			)
			$matchingEntry = TRUE;
		
		
		return $matchingEntry;
	}
	
	// TODO: patch to handle error in URI structure in submission 9
	public function getResourceIri(){
		
		$pi = trim($this->getData()[0]);
		
		$pi = preg_replace("/_/", "-", $pi);
		
		return $pi;		
	}
	
	
	
	protected function getArticleDataToDisplayAsArray(){
		
		$valuesToDisplay = array();
		
		$valuesToDisplay[] = htmlspecialchars($this->getResourceIri());
		$valuesToDisplay[] = $this->getShortenedTitle(75);
		
		return $valuesToDisplay;
		
	}
	
	
	
}


?>