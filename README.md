# SemPubEvaluator
Scripts to run the evaluation for the best-performing tool @ SemPub Challenge

## Description

The script takes as input two directories that contain CSV files with a common structure. 
One directory contains the gold standard, the other the output under evaluation.

Each CSV file contains the output of a query and is named after that query (es. ``Q2.1a.csv``).
The tool compares pairs of corresponding CSV files, with the same name, from the two directories and saves the results in a HTML report.

For each type of entry (es. article, funding agency, grant, ontology, etc.) specific comparison strategies are implemented (in the ``matchesEntry`` method of the corresponding ``Entry`` class).
The evaluation is implemented so as to take minor differences into account and to normalize data.
 
## Queries Description 

The list of queries to evaluate and the classes implementing the evaluation are specified in a configuration file passed as input.

The queries used for the Semantic Publishing Challenge 2015 are in the folder ``queries/queries-SemPub2015/``.

The queries used for the Semantic Publishing Challenge 2016 are in the folder ``queries/queries-SemPub2016/``.

### Gold standard

The directory ``gold-standard/`` contains the gold standard used for the training phase and the evaluation (when available).

The gold standard used for the training phase in 2016 are in the folder: ``gold-standard/2016/TD/`` (one folder for each task).

## How to run the evaluation
 
Run the script ``run.php`` as follows:

    run.php <queries.csv> <gold-standard-dirpath> <input-dirpath> <output-dirpath> [-sub=<submission-number>] [-task=<task-number>]

For instance,

    run.php queries/SemPub2016/Task3_queries_TD.csv gold-standard/SemPub2016/Task3/TD/ mySubmission/ output/

the aforementioned command would run the test for the Task 3 Training Dataset.
It compares the given results (available in the ``mySubmission/`` folder) with the expected results according to the gold-standard.
The results of the evaluation will be made available in the ``output/`` folder.

To run the evaluation on the Task 2 Training dataset use:

    run.php queries/SemPub2016/Task2_queries_TD.csv gold-standard/SemPub2016/Task2/TD/ mySubmission/ output/


Parameters are:

1.  queries.csv: list of queries being evaluated
2.  gold-standard-dirpath: directory with the gold standard files
3.  input-dirpath: directory with the CSV files being evaluated
4.  output-dirpath: output directory (will be overwritten)
5.  (optional) submission number (shown in the final report)
5.  (optional) task number (shown in the final report)
