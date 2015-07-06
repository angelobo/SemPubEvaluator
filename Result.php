<?php

class Result {
	
	private $evaluationLevel;
	
	private $label;
	private $description;
	
	private $goldStandard;
	private $poolUnderEvaluation;
		
	
	public function getEvaluationLevel(){
		return $this->evaluationLevel;
	}
	
	public function setEvaluationLevel($level){
		$this->evaluationLevel = $level;
	}
	
	public function setDescription($description){
		$this->description = $description;
	}
	
	public function getDescription(){
		return $this->description;	
	}
	
	public function setLabel($label){
		$this->label = $label;
	}
	
	public function getLabel(){
		return $this->label;
	}
	
	public function setGoldStandard($entries){
		$this->goldStandard = $entries;
	}
	
	public function getGoldStandard(){
		return $this->goldStandard;
	}
	
	public function setPoolUnderEvaluation($entries){
		$this->poolUnderEvaluation = $entries;
	}
	
	public function getPoolUnderEvaluation(){
		return $this->poolUnderEvaluation;
	}
	
	public function getPrecision(){
		$numberOfTruePositives = $this->getTruePositives();
		
		$sum = $numberOfTruePositives + $this->getFalsePositives();
	
		if ($sum == 0)
			$precision = "n.a.";
		else
			$precision = $numberOfTruePositives / $sum;

		// TODO: handle "n.a."
		return round($precision,3) ;
	}
	
	public function getRecall(){
		
		$numberOfTruePositives = $this->getTruePositives();
		
		$sum = $numberOfTruePositives + $this->getFalseNegatives();
		if ($sum == 0)
			$recall = "n.a.";
		else
			$recall = $numberOfTruePositives / $sum;

		// TODO: handle "n.a."
		return round($recall,3);
	}
	
	public function getFScore(){

		$p = $this->getPrecision();
		$r = $this->getRecall();
		
		$f = 0;
		if (($p + $r) != 0)
			$f = round(2 * ($p * $r) / ($p + $r), 3);
		
		return $f;
	}
	
	public function getTruePositives(){
		
		$tpCounter = 0;
		foreach ($this->getPoolUnderEvaluation()->getAllEntries() as $evalEntry) {
			if ($evalEntry->getStatus() == "TP")
				$tpCounter++;
		}
		
		return $tpCounter;
	}
	
	public function getFalsePositives(){
		
		$fpCounter = 0;
		foreach ($this->getPoolUnderEvaluation()->getAllEntries() as $evalEntry) {
			if ($evalEntry->getStatus() == "FP")
				$fpCounter++;
		}
		
		return $fpCounter;
	}
	
	public function getFalseNegatives(){
		
		$fnCounter = 0;
		foreach ($this->getGoldStandard()->getAllEntries() as $evalEntry) {
			if ($evalEntry->getStatus() == "FN")
				$fnCounter++;
		}
		
		return $fnCounter;
		
	}
	
	public function renderAsHTML($enableNavigationBar = TRUE, $queryID){

		$htmlContent = "";

		$queryNavigationBar = "";
		
		$queryShortID = explode(".", $queryID)[1];
		
		$queryShortIDLength = strlen($queryShortID) - 1;
		
		$qNumber = substr($queryShortID, 0, $queryShortIDLength);
		$qLetter = $queryShortID[$queryShortIDLength];
		$qSubNumber = ord($qLetter) - 97; // 97 position of 'a' in ASCII alphabet
		
		$nextQueryNumber = $qNumber;
		$nextSubNumber = $qSubNumber + 1;

		//TODO: add constant total number of queries (-1, index in the array)
		define("TOTALQUERIES", 10);
		define("TOTALPERQUERY", 5);
		
		if ($qSubNumber == (TOTALPERQUERY - 1))
			{
			$nextQueryNumber = $qNumber + 1;
			$nextSubNumber = 0;
			}
			
		$nextQueryID = explode(".", $queryID)[0].".".$nextQueryNumber.chr($nextSubNumber + 97);
		
		$previousButton = ""; //TODO: previous query button
		$topButton = "<span class='back-button'><a href='index.html'>[top]</a><span>";
		//TODO: fix hard-coded ".evaluation.html" substring
		$nextButton = "<span class='back-button'><a href='$nextQueryID.evaluation.html'>[&gt;&gt; $nextQueryID]</a><span>";
		
		if ($nextQueryNumber > TOTALQUERIES)
			$nextButton = "";
		
		if ($enableNavigationBar == TRUE)
			$queryNavigationBar = "<div class='navigation-bar'>$previousButton $topButton $nextButton<span class='evaluation-level'>SemPub Challenge - ".$this->getEvaluationLevel()." evaluation</span></div>";
		
		$queryHeader .= "<h2>".$this->getLabel()."</h2><p class='query-natural-language'>".$this->getDescription()."</p>";
		
		$queryScore = $this->renderSummaryAsHTMLTable();
		
		$sourcesContent = "<div class='sources-content'>";
		$sourcesContent .= "<div class='source-content'><p class='caption'>Gold Standard</p>".$this->getGoldStandard()->renderAsHTMLTable()."</div>";
		$sourcesContent .= "<div class='source-content'><p class='caption'>Under Evaluation</p>".$this->getPoolUnderEvaluation()->renderAsHTMLTable()."</div>";
		$sourcesContent .= "</div>";
		
		$htmlContent .= $queryNavigationBar;
		$htmlContent .= $queryHeader;
		$htmlContent .= $queryScore;
		$htmlContent .= $htmlContentEntries;
		$htmlContent .= $sourcesContent;
		 
		return $htmlContent;
	}
	
	private function renderSummaryAsHTMLTable(){
		
		$tableContent = "";
		
		$tableContent .= "<tr><th>Precision </th><td>".$this->getPrecision()."</td></tr>";
		$tableContent .= "<tr><th>Recall </th><td>".$this->getRecall()."</td></tr>";
		$tableContent .= "<tr><th>F-score </th><td>".$this->getFScore()."</td></tr>";
		$tableContent .= "<tr><th>Matches (TP) </th><td>".$this->getTruePositives()."</td></tr>";
		$tableContent .= "<tr><th>Missed (FN) </th><td>".$this->getFalseNegatives()."</td></tr>";
		$tableContent .= "<tr><th>Incorrect  (FP) </th><td>".$this->getFalsePositives()."</td></tr>";
				
		return "<table class='queryScore'>".$tableContent."</table>";
	}
	
	
}


?>