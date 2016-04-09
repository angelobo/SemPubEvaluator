<?php

require_once 'utils.php';

require_once 'Entry.php';
require_once 'EntryPool.php';
require_once 'Result.php';
require_once 'ResultCalculator.php';
require_once 'ResultPool.php';
require_once 'HTMLRawFormatter.php';

define("RESOURCES_SUBDIR","resources");
define("CSS_FILENAME","style.css");
define("INFO_FILENAME","info.html");
define("INDEX_OUTPUT_FILENAME","index.html");

/*
 * Load Entry Classes
*/
$entryClassesDir = __DIR__."/EntryClasses/";
$dh = opendir($entryClassesDir);

$allowedEntryClasses = array();

while ( ( $filename = readdir( $dh ) ) !== false ) {

		$path_parts = pathinfo($filename);

		if ($path_parts["extension"] == "php") {
			require_once $entryClassesDir.$filename;
			$allowedEntryClasses[] = $path_parts["filename"];
		}
	}

echo "\n********** ESWC SemPub Challenge - EVALUATION **********\n";

/*
 * Read input directory params
 */
$queryCSVFilePath = $argv[1];
$inputDirGoldStandard = $argv[2];
$inputDirUnderEvaluation = $argv[3];
$outputDir = $argv[4];

//TODO: check parameters, handle order, add documentation
$submissionNumber = substr($argv[5],strpos($argv[5], "-sub=") + 5);
$taskNumber = substr($argv[6],strpos($submissionNumber, "-task=") + 6);

$commandLineInfo = "\nCOMMAND: run.php <queries.csv> <gold-standard-dirpath> <input-dirpath> <output-dirpath> [-sub=<submission-number>] [-task=<task-number>]\n";

if (!file_exists($queryCSVFilePath))
	die("\nERROR: Input Query file missing or corrupted.\n$commandLineInfo\n");

if (!file_exists($inputDirGoldStandard))
	die("\nERROR: Gold Standard directory missing or corrupted.\n$commandLineInfo\n");

if (!file_exists($inputDirUnderEvaluation))
	die("\nERROR: Directory under evaluation missing or corrupted.\n$commandLineInfo\n");

if (!is_writable($outputDir))
	die("\nOutput directory error: missing, corrupted or not writable.\n$commandLineInfo\n");


if ($outputDir[strlen($outputDir) - 1] != "/")
	$outputDir = $outputDir. "/";

$globalResultHTMLfilename = $outputDir.INDEX_OUTPUT_FILENAME;


echo "\nQuery configuration file: ".$queryCSVFilePath;
echo "\n\nGold Standard directory: ".$inputDirGoldStandard;
echo "\nDirectory under evaluation: ".$inputDirUnderEvaluation;
echo "\n\nSubmission number: ".$submissionNumber;
echo "\nTask number: ".$taskNumber;
echo "\n";

/*
 * Copying HTML/CSS/CSV resources
 */
$cssFile = __DIR__."/".RESOURCES_SUBDIR."/".CSS_FILENAME;
$copiedCSSfile = $outputDir."/".CSS_FILENAME;

$infoFile = __DIR__."/".RESOURCES_SUBDIR."/".INFO_FILENAME;
$infoCopiedFile = $outputDir."/".INFO_FILENAME;


if ((!copy($cssFile, $copiedCSSfile)) || (!copy($infoFile, $infoCopiedFile)))
	die("Failed to copy $cssFile , $infoFile ...\n");
else 
	echo "\nResources copied. ";


$zipGoldStandard = $outputDir."gold-standard.zip";
$zipUnderEvaluation = $outputDir."under-evaluation.zip";

buildZIPfromCSVDirectory($zipGoldStandard, $inputDirGoldStandard);
buildZIPfromCSVDirectory($zipUnderEvaluation, $inputDirUnderEvaluation);

echo "ZIP files created.\n\n";


//TODO: handle loose/strict evaluation
/*
 * Evaluating queries
*/
$evaluationLevel = "loose";
$csvQueriesContent = array_map('str_getcsv', file($queryCSVFilePath));



/*
 * Init HTML formatter and ResultPool
*/
$htmlFormatter = new HTMLRawFormatter();

$resultAll = new ResultPool();
$resultAll->setEvaluationLevel($evaluationLevel);

//TODO: Check what to do when output is expected to be empty. CSV should be in the goldstandard anyway (make it run for 2016 Task3)
for ($i = 0; $i < count($csvQueriesContent); $i++) {

	// Skip empty lines in query file
	if ($csvQueriesContent[$i][0] != NULL)
		{
		$queryID = $csvQueriesContent[$i][0];
		$queryNaturalLanguage = $csvQueriesContent[$i][1];
		$queryDetailsHTMLfilename = $outputDir."/".$queryID.".evaluation.html";
		
		$queryEntryType = trim($csvQueriesContent[$i][2]);
		
		echo "Processing query: ".$queryID."\n";
		
		// Check unsupported types
		if (!in_array($queryEntryType, $allowedEntryClasses))
			die("\nERROR: Entry Type $queryEntryType not supported. Please check query file ($queryCSVFilePath).\n\n");	
		
		$queryResultExpectedFilePath = $inputDirGoldStandard."/".$queryID.".csv";
		$queryResultGivenFilePath = $inputDirUnderEvaluation."/".$queryID.".csv";
	
		$underEvaluation = new EntryPool($queryEntryType);
		$underEvaluation->loadEntriesFromCSVFile($queryResultGivenFilePath, $queryEntryType);
		
		// TODO: Check if header are missing
		$expectedOutput = new EntryPool($queryEntryType);
		$expectedOutput->loadEntriesFromCSVFile($queryResultExpectedFilePath, $queryEntryType);
		
		$resultCalculator = new ResultCalculator();
		
		$result = $resultCalculator->compare($expectedOutput, $underEvaluation, $evaluationLevel);
		$result->setEvaluationLevel($evaluationLevel);
		$result->setLabel($queryID);
		$result->setDescription($queryNaturalLanguage);
		
		$resultAll->addResult($result);
		
		$queryResultHTMLContent = $result->renderAsHTML(TRUE, $queryID);
		$queryDetailsHTML = $htmlFormatter->buildHTML($queryResultHTMLContent);
		
		$htmlFileHandler = fopen($queryDetailsHTMLfilename,"w");
		fwrite($htmlFileHandler, $queryDetailsHTML);
		fclose($htmlFileHandler);
		}

}

/*
 * Calculating and saving global result
 */
$globalResultHTMLContent = $htmlFormatter->renderIntroductionAsHTML($evaluationLevel, $taskNumber, $submissionNumber) . $resultAll->renderAsHTMLIndexTable(TRUE);

$globalResultHTML = $htmlFormatter->buildHTML($globalResultHTMLContent);

$htmlFileHandler = fopen($globalResultHTMLfilename,"w");
fwrite($htmlFileHandler, $globalResultHTML);
fclose($htmlFileHandler);

echo "\n\nEvaluation completed! Output saved in: $globalResultHTMLfilename\n\n";

?>
