# SemPubEvaluator
Scripts to run the evaluation for the best-performing tool @ SemPub Challenge

## Description

The script takes as input two directories that contain CSV files with a common structure. 
One directory contains the gold standard, the other the output under evaluation.

Each CSV file contains the output of a query and is named after that query (es. ``Q2.1a.csv``).
The tool compares pairs of corresponding CSV files from the two directories and saves the results in a HTML report.

For each type of entry (es. article, funding agency, grant, ontology, etc.) specific comparison strategies are implemented (in the ``matchesEntry`` method of the corresponding ``Entry`` class).
The evaluation is implemented so as to take minor differences into account and to normalize data.
 
## Queries Description

The list of queries to evaluate and the classes implementing the evaluation are specified in a configuration file passed as input.

The queries used for SemPub 2015 are in the file ``queries/queries-SemPub2015.csv``.

The queries used for the Semantic Publishing Challenge 2016 are in the folder queries/queries-SemPub2016/.
The queries used for Task 1 are in the file queries/SemPub2016/Task1_TD.csv.
The queries used for Task 2 are in the file queries/SemPub2016/Task2_TD.csv.
The queries used for Task 3 are in the file queries/SemPub2016/Task3_TD.csv.

## How to run the evaluation
 
Run the script ``run.php`` as follows:

    run.php <queries.csv> <gold-standard-dirpath> <input-dirpath> <output-dirpath> [-sub=<submission-number>] [-task=<task-number>]

For instance,
    run.php queries/SemPub2016/Task3_TD.csv gold-standard/TD/ mySubmission/ output/

the aforementioned command would run the test for the Task 3 Training Dataset.
It compares the given results (available in the mySubmission/ folder) with the expected results according to the gold-standard.
The results of the evaluation will be made available in the output/ folder.

Parameters are:

1.  queries.csv: list of queries being evaluated
2.  gold-standard-dirpath: directory with the gold standard files
3.  input-dirpath: directory with the CSV files being evaluated
4.  output-dirpath: output directory (will be overwritten)
5.  (optional) submission number (shown in the final report)
5.  (optional) task number (shown in the final report)

## How to configure the tool

TODO.

### Entry classes

### Query file
