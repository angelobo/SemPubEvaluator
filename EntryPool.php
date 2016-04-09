<?php

class EntryPool {

	private $type;
	private $columnLabels = array();
	private $entries = array();

	public function __construct($type = "Entry"){
		$this->type = $type;
	}
	
	public function getType(){
		return $this->type;
	}
	
	public function setColumnLabels($columnLabelsArray){
		$this->columnLabels = $columnLabelsArray;
	}
	
	public function getColumnLabels(){
		return $this->columnLabels;
	}
	
	public function getAllEntries(){
		return $this->entries;
	}
	
	public function getSize(){
		return count($this->entries);
	}
	
	public function addEntry($aEntry) {
		$this->entries[] = $aEntry;
	}
	
	public function setStatusOfMatchingEntry($searchEntry, $status, $evaluationLevel){
		$foundEntry = FALSE;
	
		foreach ($this->entries as $currentEntry) {
				
			if (($currentEntry->getStatus() != "TP") && $currentEntry->matchesEntry($searchEntry, $evaluationLevel) && ($foundEntry == FALSE))
				{
				$foundEntry = TRUE;
				$currentEntry->setStatus($status);
				}
		}
		
		return $foundEntry;
	}
	
	public function renderAsHTMLTable(){
	
		
		$htmlTable = "<table class='entry-pool'>";
		
		foreach ($this->getColumnLabels() as $cLabel) {
			$htmlTable .= "<th>$cLabel</th>";
		}
		
		foreach ($this->entries as $aEntry) {
			$htmlTable .= $aEntry->renderAsHTMLTableRow();
		}
		
		if ($this->getSize() == 0)
			$htmlTable .= "<tr><td>Empty set.</td></tr>";
	
		$htmlTable .= "</table>";
		
		return $htmlTable;
	}
	
	
	public function loadEntriesFromCSVFile($queryResultGivenFilePath){
	
		if (file_exists($queryResultGivenFilePath))
		{
				
			$queryEntryType  = $this->getType();
			
			$csvContent = array_map('str_getcsv', file($queryResultGivenFilePath));
	
			//TODO: control CSV header and Check if are missing. Now it assumes headers exist.
			$this->setColumnLabels($csvContent[0]);
	
			// Skip header
			for ($i = 1; $i < count($csvContent); $i++) {
				
				$lEntry = new $queryEntryType();
				
				$lEntry->setData($csvContent[$i]);
				
				$this->addEntry($lEntry);
			}
		}
	
	}
		
}


?>