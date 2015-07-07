<?php

class CEURArticleEntry extends ArticleEntry{
	
	/***
	 * 
	 * MATCHING RULES:
	 * 
	 * [Strict/Loose]: paper URIs (that have to follow challenge rules) are equal
	 *	
	 *	NOTE: symbol '_' is replaced with '-' in the IRIs
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
	
	// Normalization (to handle mistakes in some submissions): symbol '_' is replaced with '-' in the IRIs
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