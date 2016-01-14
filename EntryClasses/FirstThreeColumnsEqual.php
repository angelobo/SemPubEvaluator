<?php

class FirstThreeColumnsEqual extends Entry{
	
	public function renderAsHTMLTableRow(){
		$valuesInRow = array();
		
		$valuesInRow[] = htmlentities($this->getData()[0]);
		$valuesInRow[] = $this->getData()[1];
		$valuesInRow[] = $this->getData()[2];
		
		$tableRow = $this->renderDataAsHTMLTableRow($valuesInRow);
		
		return $tableRow;
	}

	public function matchesEntry($searchEntry, $evaluationLevel){
		return $this->getData()[0] == $searchEntry->getData()[0]
                    && $this->getData()[1] == $searchEntry->getData()[1]
                    && $this->getData()[2] == $searchEntry->getData()[2];
	}
}


?>
