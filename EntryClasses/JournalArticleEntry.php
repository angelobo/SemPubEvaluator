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
	* [Strict]: all values (apart from IRIs) are equal; DOI ignored if not available in the golden standard
	*				- journal titles must be equals
	*
	* [Loose]: paper titles are similar (by using PHP string similarity function, threshold 80% )
	*				- journal titles are ignored (underspecified in the challenge requirements and queries description
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