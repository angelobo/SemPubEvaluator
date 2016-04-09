<?php

function buildZIPfromCSVDirectory($zipOutputFile, $csvDirFullpath){

$zip = new ZipArchive();

// TODO: Handle errors in zipping files
if($zip->open($zipOutputFile, ZIPARCHIVE::CREATE) !== TRUE)
	return false;

$dh = opendir($csvDirFullpath);
while (false !== ($filename = readdir($dh))) {
	$fileInfo = pathinfo($filename);
	if ($fileInfo["extension"]=="csv")
		{	
		$csvFullpath = $csvDirFullpath . $filename;
		$zip->addFile($csvFullpath, $filename);
		}
}


$zip->close();

return true;
}


function getNumberOfQueriesAndCasesPerQuery($csvQueriesContent){
	
	$totQueries = 1;
	$totPerQuery = 0;
	
	for ($i = 0; $i < count($csvQueriesContent); $i++) {
		if ($csvQueriesContent[$i][0] != NULL){
	
			$queryIDpieces = explode(".", $csvQueriesContent[$i][0]);
			$qNumber = (int) substr($queryIDpieces[0], 1);
			$qSubNumber = (int) $queryIDpieces[1];
	
			if ($qNumber > $totQueries)
				$totQueries = $qNumber;
	
			if ($qSubNumber > $totPerQuery)
				$totPerQuery = $qSubNumber;
		}
	}
	
	return [$totQueries, $totPerQuery];
}

?>