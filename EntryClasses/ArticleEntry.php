<?php

class ArticleEntry extends Entry{
	
	public function getResourceIri(){
		return trim($this->getData()[0]);		
	}
	
	public function getDOI(){
		return trim($this->getData()[1]);
	}	
	
	public function getTitle(){
		return trim($this->getData()[2]);	
	}
	
	public function getNormalizedTitle(){
		$nt = $this->getTitle();
		$nt = preg_replace("/[^a-zA-Z0-9]+/", "", $nt);
				
		return strtolower($nt);
	}
	
	
	public function getShortenedTitle($length = 50){
		$content = $this->getTitle();
		
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
	 * [Strict]: all values (apart from IRIs) are equal; DOI ignored if not available in the golden standard
	 * 
	 * [Loose]: title are similar (by using PHP string similarity function, threshold 80% )
	 *
	 */
		 
	public function matchesEntry($searchEntry, $evaluationLevel){
	
		$matchingEntry = FALSE;
	
		if ($evaluationLevel == "loose"){
			
			similar_text($this->getNormalizedTitle(), $searchEntry->getNormalizedTitle(), $similarity);
				
			if (( $similarity > 80 )  && ( $this->getTitle()))
				$matchingEntry = TRUE;
			
		}
		else {
			if (
			(($this->getDOI() == $searchEntry->getDOI()) || ($searchEntry->getDOI() == "")   )  &&
			($this->getNormalizedTitle() == $searchEntry->getNormalizedTitle())
			)
				$matchingEntry = TRUE;
		}
		
		return $matchingEntry;
	}

	
	public function renderAsHTMLTableRow(){
		
		$valuesInRow = $this->getArticleDataToDisplayAsArray();
		
		$tableRow = $this->renderDataAsHTMLTableRow($valuesInRow);
		
		return $tableRow;
		
	}
	
	protected function getArticleDataToDisplayAsArray(){
		
		$valuesToDisplay = array();
		
		$valuesToDisplay[] = htmlspecialchars($this->getResourceIri());
		$valuesToDisplay[] = $this->getDOI();
		$valuesToDisplay[] = $this->getShortenedTitle(100);
		
		return $valuesToDisplay;
		
	}
	
	
	/***
	 * 
	 * Patch to handle SemPub2015 - submission 7
	 * //TODO: remove and fix input data
	 * 

	public function getNormalizedTitleErrorInWrongColumnsOrder(){
		$nt = trim($this->getData()[1]);
		$nt = preg_replace("/[^a-zA-Z0-9]+/", "", $nt);
	
		return strtolower($nt);
	}

	public function matchesEntry($searchEntry, $evaluationLevel){
	
		$matchingEntry = FALSE;
	
		if ($evaluationLevel == "loose"){
				
			similar_text($this->getNormalizedTitleErrorInWrongColumnsOrder(), $searchEntry->getNormalizedTitle(), $similarity);
	
			if (( $similarity > 80 )  && ( $this->getNormalizedTitleErrorInWrongColumnsOrder()))
				$matchingEntry = TRUE;
		}
		// strict evaluation always fails (errors in input data)
	
		return $matchingEntry;
	}
	
	***/
	
}


?>