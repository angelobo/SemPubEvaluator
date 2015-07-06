<?php

class ProjectEntry extends Entry{
	
	public function getProjectIRI(){
		return trim($this->getData()[0]);		
	}

	public function getProjectName(){
		return trim($this->getData()[1]);
	}
		
	public function getNormalizedProjectName(){
		$np = $this->getProjectName();
		$np = strtolower($np);
		$np = preg_replace("/\sproject/", "", $np);
	
		return trim($np);
	}
	
	public function renderAsHTMLTableRow(){
		
		$valuesInRow = array();
		
		$valuesInRow[] = htmlentities($this->getProjectIRI());
		$valuesInRow[] = $this->getProjectName();
		
		$tableRow = $this->renderDataAsHTMLTableRow($valuesInRow);
		
		return $tableRow;
		
	}

	/***
	 * 
	 * MATCHING RULES:
	 * 
	 * [Strict/Loose]: 
	 * 			- equal Project name (lowercase, removing the word "project" if there
	 * 
	 *
	 */
	public function matchesEntry($searchEntry, $evaluationLevel){
	
		$matchingEntry = FALSE;
	
		if ($this->getNormalizedProjectName() == $searchEntry->getNormalizedProjectName())
			$matchingEntry = TRUE;
		
		return $matchingEntry;
	}
}


?>