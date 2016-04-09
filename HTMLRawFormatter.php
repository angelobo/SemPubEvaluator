<?php

class HTMLRawFormatter {
	
	
	public function buildHTML($bodyContent){
	
		$htmlStart = "
		<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>
		<html>
			<head>
				<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
				<title>ESWC - Semantic Publishing Challenge Evaluation</title>
				<link rel='stylesheet' type='text/css' href='style.css'/>
			</head>
			<body>";
		
		$htmlEnd = "</body></html>";
		
		date_default_timezone_set("CET");
		$timestampDIV = "<div class='generatedTS'>Generated on: ".date("D, d M Y H:i:s")."</div>";

		$html = $htmlStart.$bodyContent.$timestampDIV.$htmlEnd;
		
		return $html;
	}
	
	
	public function renderIntroductionAsHTML($evaluationLevel, $taskNumber, $submissionNumber, $zipOption){
			
		$htmlIntroContent = "
		<h1>SemPub Challenge @ ESWC  - Evaluation</h1>
		<p>This page shows the results of the evaluation of submission <b>#$submissionNumber</b>, for the best-performing approach of task #$taskNumber. See <a href='https://github.com/ceurws/lod/wiki/' target='_blank'>SemPub Challenge wiki</a> for more information.</p>
		<p>The output of some queries on the submitted LOD is compared with a gold standard, and precision and recall are measured.
		Both the gold standard and the output under evaluation are expected to be CSV files with a common structure.</p>";
		
		if ($zipOption)
			$htmlIntroContent = $htmlIntroContent . "<p>The source files are available here (as ZIP archives): <a href='".ZIP_GOLD_STANDARD."'>Gold Standard</a> and <a href='".ZIP_UNDER_EVALUATION."'>Output Under Evaluation</a>. Note that CSV files are not included in the ZIP file under evaluation if the corresponding query returned an empty output.</p>";
		
		$htmlIntroContent = $htmlIntroContent . "<p>The evaluation process is described in <a href='info.html' target='_blank'>info.html</a>. This page shows the results of the <i>$evaluationLevel</i> evaluation.</p>";
	
		return "<div class='intro'>".$htmlIntroContent."</div>";
	}
}
?>