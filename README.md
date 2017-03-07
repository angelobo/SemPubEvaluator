# SemPubEvaluator
Scripts to run the evaluation for the best-performing tool @ SemPub Challenge

## Description

The script takes as input two directories that contain CSV files with a common structure. 
One directory contains the gold standard, the other the output under evaluation.

Each CSV file contains the output of a query and is named after that query (es. ``Q2.1a.csv``).
The tool compares pairs of corresponding CSV files from the two directories and saves the results in a HTML report.
**Corresponding files must have the same name.**


For each type of entry (es. article, funding agency, grant, ontology, etc.) specific comparison strategies are implemented 
(in the ``matchesEntry`` method of the corresponding ``Entry`` class).
The evaluation is implemented so as to take minor differences into account and to normalize data.
 
## Queries Description 

The list of queries to evaluate and the classes implementing the evaluation are specified in a configuration file passed as input.

The queries used for the Semantic Publishing Challenge 2015 are in the folder ``data/SemPub2015/queries/``.

The queries used for the Semantic Publishing Challenge 2016 are in the folder ``data/SemPub2016/queries/``.

The queries used for the Semantic Publishing Challenge 2017 are in the folder ``data/SemPub2017/queries/``.

### Gold standard

The distribution also contains the gold standard used for the training phase and the evaluation (when available).

The gold standard used for the training phase in 2017 are in the folders: ``data/SemPub2017/gold-standard/Task1/TD/``, ``data/SemPub2017/gold-standard/Task2/TD/`` and ``data/SemPub2017/gold-standard/Task3/TD/``.

### Final evaluation

The gold standard used for the final evaluation will be released a few days before the deadline.

## How to run the evaluation
 
Run the script ``run.php`` as follows:

    php run.php <queries.csv> <gold-standard-dirpath> <input-dirpath> <output-dirpath> [-sub=<submission-number>] [-task=<task-number>] [--create-zip]

Parameters are:

1.  queries.csv: list of queries being evaluated
2.  gold-standard-dirpath: directory with the gold standard files
3.  input-dirpath: directory with the CSV files being evaluated
4.  output-dirpath: output directory (will be overwritten)
5.  (optional) submission number (shown in the final report)
5.  (optional) task number (shown in the final report)
5.  (optional) flag to zip input CSV files and include them in the output

For instance, to run the test for the Task 2 Training Dataset:

    php run.php data/SemPub2017/queries/Task2_queries_TD.csv data/SemPub2017/gold-standard/Task2/TD/ mySubmission/ output/

The command compares the given results (available in the ``mySubmission/`` folder) with the expected results according to the gold-standard.
The results of the evaluation will be made available in the ``output/`` folder. 
Please open ``output/index.html`` to read the evaluation report.

To run the **evaluation on the Task 1 Training Dataset** use:

    php run.php data/SemPub2017/queries/Task1_queries_TD.csv data/SemPub2017/gold-standard/Task1/TD/ <mySubmissionDir> <outputDir>
    
To run the **evaluation on the Task 2 Training Dataset** use:

    php run.php data/SemPub2017/queries/Task2_queries_TD.csv data/SemPub2017/gold-standard/Task2/TD/ <mySubmissionDir> <outputDir>

To run the **final evaluation on the Task 2 Evaluation Dataset** use:

    php run.php data/SemPub2017/queries/Task2_queries_ED.csv data/SemPub2017/gold-standard/Task2/ED/ <mySubmissionDir> <outputDir>

Please open ``output/index.html`` to read the evaluation report.



