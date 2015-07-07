<?php

class JournalArticleEntry extends ArticleEntry{
	
	public function getJournalTitle(){
		return trim($this->getData()[3]);
	}
	
	public function renderAsHTMLTableRow(){
		
		$valuesInRow = $this->getArticleDataToDisplayAsArray();
		
		$valuesInRow[] = $this->getJournalTitle();
		
		$tableRow = $this->renderDataAsHTMLTableRow($valuesInRow);
		
		return $tableRow;
	
	}
	
	
	
	/***
	 *
	* MATCHING RULES:
	*
	* [Strict]: DOI, paper titles (normalized as for all other articles) and journal titles must be equal
	*
	* [Loose]: 
	* 		- DOI must be equal (if available in the gold standard)
	* 		- paper titles similar (by using PHP string similarity function, threshold 80% )
	*		- journal titles are ignored, since they were under specified in the challenge requirements)
	*/
	public function matchesEntry($searchEntry, $evaluationLevel){
	
		$matchingEntry = FALSE;
	
		if ($evaluationLevel == "loose"){
				
			similar_text($this->getNormalizedTitle(),$searchEntry->getNormalizedTitle(), $similarityTitle);
			similar_text($this->getJournalTitle(),$searchEntry->getJournalTitle(), $similarityJournal);
			
			if (( $similarityTitle > 80 )  && ( $this->getTitle()))
				$matchingEntry = TRUE;
		}
		else {
			if (
			(($this->getDOI() == $searchEntry->getDOI()) || ($searchEntry->getDOI() == "")   )  &&
			($this->getNormalizedTitle() == $searchEntry->getNormalizedTitle()) &&
			($this->getJournalTitle() == $searchEntry->getJournalTitle())
			)
				$matchingEntry = TRUE;
		}
	
		return $matchingEntry;
	}
	

	
}


?>