<?php

/**
 * Created by: Alatise Oluwaseun aka - holynation
 * Email: holynation667@gmail.com 
 * Lang: PHP
 * Date created: 27-08-2021 01:30am
 * 
*/


// setting some error reporting config
error_reporting(E_ALL);
ini_set("display_errors", 1);

// including the necessary files
include_once 'function.php';

// declaring all the variables needed here
$result = array();
$outputName = "output.csv";
$fileInputName = "data.csv";

// fetching the data from csv
$content = loadFileContent($fileInputName);
$array = stringToCsv($content);

// getting the first array index value based on the column needed
$header = array_shift($array);
$mobileIndex = array_search('Mobile', $header);
$targetIndex = array_search('Target Repay Rate', $header);
$repayIndex = array_search('Repay Rate', $header);
$nameIndex = array_search('Collector Name', $header);

// filter out those that passed the criteria
$tempRes = filterOutCriteria($array,$mobileIndex,$targetIndex,$repayIndex,$nameIndex);

// here is where i counted the number of occurrences
$result = analyseResult($tempRes,$outputName);
echo "Data analysis completed"

?>