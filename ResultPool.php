<?php

class ResultPool {

	private $evaluationLevel;
	
	private $results = array();

	public function getEvaluationLevel(){
		return $this->evaluationLevel;
	}
	
	public function setEvaluationLevel($level){
		$this->evaluationLevel = $level;
	}
	
	public function addResult($result) {
		$this->results[] = $result;
	}
	
	public function getAveragePrecision(){

		$numberOfResults = count($this->results);
		
		$total = 0;
		
		foreach ($this->results as $res) {
			$total += $res->getPrecision();
		}
		
		$average = $total / $numberOfResults;
		
		return round($average,3);
	}
	
	public function getAverageRecall(){
	
		$numberOfResults = count($this->results);
	
		$total = 0;
	
		foreach ($this->results as $res) {
			$total += $res->getRecall();
		}
	
		$average = $total / $numberOfResults;
	
		return round($average,3);
	}
	
	public function getAverageFScore(){
	
		$numberOfResults = count($this->results);
	
		$total = 0;
	
		foreach ($this->results as $res) {
			$total += $res->getFScore();
		}
	
		$average = $total / $numberOfResults;
	
		return round($average,3);
	}
	
	
	public function getSize(){
		return count($this->entries);
	}
	
	public function renderAsHTMLIndexTable($enableLinkToDetails = TRUE){
	
	
	$htmlIndexTableContent = "";
	
	$htmlIndexTableContent .= "<p class='overall-score'>Average Precision: ".$this->getAveragePrecision()."</p>";
	$htmlIndexTableContent .= "<p class='overall-score'>Average Recall: ".$this->getAverageRecall()."</p>";
	$htmlIndexTableContent .= "<p class='overall-score'>Average F-Score: ".$this->getAverageFScore()."</p>";
	
	
	$htmlIndexTableHeader = "<tr><th>Query #ID</th><th>Precision</th><th>Recall</th><th>F-score</th><th>TP</th><th>FN</th><th>FP</th>";
	
	if ($enableLinkToDetails == TRUE)
		$htmlIndexTableHeader .="<th></th>";
	
	$htmlIndexTableHeader .= "</tr>";
	
	foreach ($this->results as $singleQueryResult) {
		
		$rowHTML = "<tr>";
		
		$label = $singleQueryResult->getLabel();
	
		$rowHTML .= "<td>".$label."</td>";
		
		$rowHTML .= "<td>".$singleQueryResult->getPrecision()."</td>";
		$rowHTML .= "<td>".$singleQueryResult->getRecall()."</td>";
		$rowHTML .= "<td>".$singleQueryResult->getFscore()."</td>";
		$rowHTML .= "<td>".$singleQueryResult->getTruePositives()."</td>";
		$rowHTML .= "<td>".$singleQueryResult->getFalseNegatives()."</td>";
		$rowHTML .= "<td>".$singleQueryResult->getFalsePositives()."</td>";

		if ($enableLinkToDetails == TRUE)
			$rowHTML .="<td><a href='".$label.EVALUATION_QUERY_REPORT_SUFFIX."'>Details</a></td>";
			
		$rowHTML .= "</tr>";

		$htmlIndexTableContent .= $rowHTML;
		}
	
	return "<table class='all-query-results'>".$htmlIndexTableHeader.$htmlIndexTableContent."</table>";
	}
	

	
}


?>