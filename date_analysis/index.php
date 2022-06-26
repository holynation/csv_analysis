<?php

/**
 * Created by: Alatise Oluwaseun aka - holynation
 * Email: holynation667@gmail.com 
 * Lang: PHP
 * Date created: 26-06-2022 03:30pm
 * 
*/


// setting some error reporting config
error_reporting(E_ALL);
ini_set("display_errors", 1);

// including the necessary files
include_once 'function.php';

// declaring all the variables needed here
$result = array();
$outputName = "housing_form_1_date_formatted.csv";
$fileInputName = "data_1.csv";
$headerTitle = array('PF. NO.', 'Appointment Date', 'Date of Application');

// fetching the data from csv
$content = loadFileContent($fileInputName);
$array = stringToCsv($content);

// getting first the array index value based on the column needed
$header = array_shift($array);
$pfIndex = array_search('pf_no', $header);
$dateAppointIndex = array_search('appointment_date', $header);
$appDateIndex = array_search('application_date', $header);

// filter out those that passed the criteria
$tempRes = formatToMysqlDate($array,$pfIndex,$dateAppointIndex,$appDateIndex);
// format array data to csv
$result = convertDataToCsv($outputName,$tempRes,$headerTitle);
echo "Data analysis completed";

?>