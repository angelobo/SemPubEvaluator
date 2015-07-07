<?php

class RecentArticleEntry extends ArticleEntry{
	
	public function getPublicationYear(){
		return trim($this->getData()[3]);		
	}
	
	public function getErrorMsg(){
		return trim($this->getData()[4]);	
	}
	
	public function getNormalizedPublicationYear(){
		
		$pubYear = $this->getPublicationYear();
		
		if (!(strpos($this->getPublicationYear(), "^^xsd:integer") === FALSE))
			$pubYear = substr($this->getPublicationYear(), 0 , strpos($this->getPublicationYear(), "^^xsd:integer"));
			
		return 	$pubYear;	
	}
	
	/***
	*
	* MATCHING RULES:
	*
	* [Strict]: DOI, paper titles (normalized as for all other articles) and publication year must be equal
	*				- "^^xsd:integer" is not considered in the publication year
	* [Loose]:
	* 		- DOI must be equal (if available in the gold standard)
	* 		- paper titles similar (by using PHP string similarity function, threshold 80% )
	*		- "^^xsd:integer" is not considered in the publication year
	*		- months are not taken into account in the publication year
	*/
	public function matchesEntry($searchEntry, $evaluationLevel){
	
		$matchingEntry = FALSE;
	
		if ($evaluationLevel == "loose"){
			
			similar_text($this->getNormalizedTitle(),$searchEntry->getNormalizedTitle(), $similarity);
				
			if ((( $similarity > 80 )  && ( $this->getTitle())) &&
				
				// Note: the keyword ERROR-IGNORE-PUBYEAR is used in the queries configuration file to handle entries with 
				//		no publication year is available in the gold standard (error)
				(!(strpos($this->getNormalizedPublicationYear(), $searchEntry->getNormalizedPublicationYear()) === FALSE) || 
				($searchEntry->getErrorMsg() == "ERROR-IGNORE-PUBYEAR"))
			
				)
				$matchingEntry = TRUE;
		}
		else {
			if (
			(($this->getDOI() == $searchEntry->getDOI()) || ($searchEntry->getDOI() == "")   )  &&
			($this->getNormalizedTitle() == $searchEntry->getNormalizedTitle()) &&
			(($this->getNormalizedPublicationYear() == $searchEntry->getNormalizedPublicationYear()) || ($searchEntry->getErrorMsg() == "ERROR-IGNORE-PUBYEAR"))
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
		$valuesToDisplay[] = $this->getShortenedTitle(125);
		
		$py = $this->getPublicationYear();
		
		$valuesToDisplay[] = $this->getPublicationYear();
		
		return $valuesToDisplay;
		
	}
	
	
	
}


?>