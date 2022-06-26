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

function filterOutCriteria($array,$mobileIndex,$targetIndex,$repayIndex,$nameIndex){
	$current = array();
	$result = array();

	for($i = 0;$i<count($array); $i++){
		$temp = $array[$i];
		$mobile = $temp[$mobileIndex];
		$target = floatval(str_replace('%', '',$temp[$targetIndex]));
		$repayRate = floatval(str_replace('%','',$temp[$repayIndex]));

		if($repayRate >= $target){
			$current['collect_name'] = $temp[$nameIndex];
			// $current['Total Amount Repaid'] = $temp['Total Amount Repaid'];
			$current['mobile'] = $temp[$mobileIndex];
			$result[] = $current;
		}
	}
	return $result;
}

function analyseResult($tempRes = array(),$filename){
	$lidCount = array();
	$result = array();

	foreach ($tempRes as $arr) {
		$temp = $arr;
		$current = $arr['mobile'];
		if (isset($lidCount[$arr['mobile']])) {
		    $lidCount[$arr['mobile']]++;
		}else {
		    $lidCount[$arr['mobile']] = 1;
		    $result[$current] = $temp;
	  	}
	}

	// formatting the array for easy reading
	$fp = fopen($filename,'w');
	foreach($result as $key => $val){
		if($lidCount[$key]){
			$recent = $val;
			$recent['count times'] = $lidCount[$key];
			fputcsv($fp, $recent);
		}
	}
	fclose($fp);
	return $recent;
}