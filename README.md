# SemPubEvaluator
Scripts to run the evaluation for the best-performing tool @ SemPub Challenge

## Description

The script takes as input two directories that contain CSV files with a common structure. 
One directory contain the gold standard, the other the output under evaluation.

Each CSV file is the output of a query and is named after that query (es. ``Q2.1a``).
Pairs of corresponding CSV files (with the same name) are compared and the results are saved in a HTML report.

The evaluation is implemented so as to take minor differences into account and to normalize data.
For each type of entry (es. article, funding agency, grant, ontology, etc.) specific comparison strategies are implemented (in the ``matchesEntry`` method of the corresponding ``Entry`` class).
 
The list of queries to evaluate and the classes implementing the evaluation are specific in a configuration file passed as input.


## How to run the evaluation
 
Run the script ``run.php`` as follows:

    run.php <queries.csv> <gold-standard-dirpath> <input-dirpath> <output-dirpath> [-sub=<submission-number>] [-task=<task-number>]

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