<?php

function loadFileContent($path)
{
	$content = file_get_contents($path);
	return $content;
}

function stringToCsv($string){
	$result = array();
	$lines = explode("\n", trim($string));
	for ($i=0; $i < count($lines); $i++) { 
		$current  = $lines[$i];
		$result[]=str_getcsv(trim($current));
	}
	return $result;
}

function formatToDateDb($dateTime){
	$date = new DateTime($dateTime);
	return $date->format('Y-m-d');
}

function formatDateWithSlash(string $date){ #18405 19560
	$tempDate = explode("/",trim($date));
    $day = ($tempDate[0] <= 12) ? $tempDate[1] : $tempDate[0];
    $month = ($tempDate[0] <= 12) ? $tempDate[0] : $tempDate[1];
    $year = $tempDate[2] ?? '';
    return $year."-".$month."-".$day;
}

function formatToMysqlDate(array $array,int $pfIndex,int $dateAppointIndex,int $appDateIndex){
	$current = array();
	$result = array();

	// print_r($array);exit;
	for($i = 0;$i<count($array); $i++){
		$temp = $array[$i];
		$dateAppoint = $temp[$dateAppointIndex];
		$appDateAppoint = $temp[$appDateIndex];

		if($dateAppoint){
			if(strpos($dateAppoint, '/') !== false){
	            $temp[$dateAppointIndex] = formatDateWithSlash($dateAppoint);
			}
			else if(preg_match('~[A-Za-z]~', $dateAppoint)){
				$temp[$dateAppointIndex] = formatToDateDb(trim($dateAppoint));
			}
		}else{
			$temp[$dateAppointIndex] = '';
		}

		if($appDateAppoint){
			if(strpos($appDateAppoint, '/') !== false){
	            $temp[$appDateIndex] = formatDateWithSlash($appDateAppoint);
			}else if(strlen($appDateAppoint) <= 5){
				$temp[$appDateIndex] = $appDateAppoint;
			}
			else{
				$temp[$appDateIndex] = formatToDateDb(trim($appDateAppoint));
			}
		}else{	
			$temp[$appDateIndex] = '';
		}
		$result[] = $temp;
	}
	return $result;
}

function convertDataToCsv(string $filename,$data = array(),array $headerTitle){
	// formatting the array for easy reading
	$fp = fopen($filename,'w+');
	$headerTitleFlag = false;
	foreach($data as $val){
		if(!$headerTitleFlag){
			fputcsv($fp, $headerTitle);
			$headerTitleFlag = true;
		}
		fputcsv($fp, $val);
	}
	fclose($fp);
}