<?php

require_once 'Result.php';


class ResultCalculator {

	public function compare($goldStandard, $givenOutput, $evaluationLevel = "strict"){
	
		$result = new Result();
		$result->setGoldStandard($goldStandard);
		$result->setPoolUnderEvaluation($givenOutput);
		
		$goldStandardEntries = $goldStandard->getAllEntries();
		
		foreach ($goldStandardEntries as $goldStandardEntry) {
				
			$matchFound = $givenOutput->setStatusOfMatchingEntry($goldStandardEntry,"TP", $evaluationLevel);
			
			if ($matchFound == TRUE)
				$goldStandardEntry->setStatus("MATCH");
			else 
				$goldStandardEntry->setStatus("FN");
			
		}
	
		$givenOutputEntries = $givenOutput->getAllEntries();
	
		foreach ($givenOutputEntries as $givenOutputEntry) {
				
			if ($givenOutputEntry->getStatus() != "TP")
				$givenOutputEntry->setStatus("FP");			
		}
	
		return $result;
	}
	
}


?>