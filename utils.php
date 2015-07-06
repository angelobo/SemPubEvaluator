<?php

function buildZIPfromCSVDirectory($zipOutputFile, $csvDirFullpath){

$zip = new ZipArchive();

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

// TODO: Handle errors in zipping files
$zip->close();

return true;
}

?>