<?php


abstract class Entry {
	
	private $data;
	private $status;
	
	public function getData(){
		return $this->data;
	}
	
	public function setData($data){
		$this->data = $data;
	}
	
	
	public function setStatus($status){
		$this->status = $status;
	} 
	
	public function getStatus(){
		return $this->status;	
	}
	
	abstract public function matchesEntry($searchEntry, $evaluationLevel);
	
	abstract public function renderAsHTMLTableRow();
	
	protected function removeDataTypeFromString($givenValue){
	
		$datatypePos = strpos($givenValue, "^^");
	
		if ($datatypePos > 0)
			$givenValue = substr($givenValue, 0,$datatypePos);
	
		return $givenValue;
	}
	
	protected function renderStatusAsHTMLspan(){
		
		$htmlFragment = "";
		
		switch ($this->getStatus()) {
			case "TP":
			case "MATCH":
				$text = "MATCH";
				$class = "status-tp";
				break;
			case "FP":
			$text = "FP";
			$class = "status-fp";
			break;
			case "FN":
			$text = "MISSED";
			$class = "status-fn";
			break;
			default:
			$text = "";
			$class = "status";
			break;
		}
		
		$htmlFragment = "<span class='$class'>$text</span>";
		
		return $htmlFragment;
	}
		
	protected function renderDataAsHTMLTableRow($arrayOfValues, $enableStatus = TRUE){
		
		if ($enableStatus == TRUE)
			$arrayOfValues[] = $this->renderStatusAsHTMLspan();	
		
		$tableRow = "<tr>";
	
		foreach ($arrayOfValues as $value) {
			$tableRow.=  "<td>".$value."</td>";
		}
	
		$tableRow.=  "</tr>";
	
		return $tableRow;
	}
	
}


?>