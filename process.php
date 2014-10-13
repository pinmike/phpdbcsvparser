<?php

$inputFileName = 'exampleinput.csv';
$outputFileName = 'exampleOutput.csv';

$inputFile = fopen($inputFileName, 'r');
$outputFile = fopen($outputFileName, 'a');

$dates = array();
$indexes = array();
$processData = array();
$outputHeaderLine = "";
$outputLine = "";

while(($line = fgetcsv($inputFile)) !== FALSE)
{
	$index = $line[0];
	$date = $line[1];
	$value = $line[2];

	$processData[$date][$index] = $value;

	if(!in_array($date, $dates))
	{
		$dates[] = $date;
	}

	if(!in_array($index, $indexes))
	{
		$indexes[] = $index;
	}
}

$outputHeaderLine = "date,".implode(',', $indexes)."\n";
fwrite($outputFile, $outputHeaderLine);

foreach($processData as $date => $dateData)
{
	$outputLine = $date;

	foreach($indexes as $index)
	{
		if(array_key_exists($index, $dateData))
		{
			$outputLine .= ','.$dateData[$index];
		} else
		{
			$outputLine .= ',0';
		}
	}

	fwrite($outputFile, $outputLine."\n");
}

fclose($inputFile);
fclose($outputFile);
