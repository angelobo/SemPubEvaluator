<?php

class FirstColumnEqual extends Entry{
	
	public function renderAsHTMLTableRow(){
		$valuesInRow = array();
		
		$valuesInRow[] = htmlentities($this->getData()[0]);
		
		$tableRow = $this->renderDataAsHTMLTableRow($valuesInRow);
		
		return $tableRow;
	}

	public function matchesEntry($searchEntry, $evaluationLevel){
		return trim(lowercase($this->getData()[0])) == trim(lowercase($searchEntry->getData()[0]));
	}
}


?>
