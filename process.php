<?php

/** Simple script to take a csv file in one form and output it in another */

$inputFileName		= 'exampleinput.csv';
$outputFileName 	= 'exampleOutput.csv';
$dates 				= array();
$indexes 			= array();
$processData 		= array();
$outputHeaderLine 	= "";
$outputLine 		= "";

// Get handles on the in and out files
$inputFile 			= fopen($inputFileName, 'r');
$outputFile 		= fopen($outputFileName, 'a');

// Iterate over each csv file line, parsing data in to new array
while(($line = fgetcsv($inputFile)) !== FALSE)
{
	$index 	= $line[0];
	$date 	= $line[1];
	$value 	= $line[2];

	// Add to new array
	$processData[$date][$index] = $value;

	// Maintain an array of known date values
	if(!in_array($date, $dates))
	{
		$dates[] = $date;
	}

	// Maintain an array of known index values
	if(!in_array($index, $indexes))
	{
		$indexes[] = $index;
	}
}

// Create and output the csv header line
$outputHeaderLine = "date,".implode(',', $indexes)."\n";
fwrite($outputFile, $outputHeaderLine);

// Iterate over new array and write csv lines to file
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

// Close file handles
fclose($inputFile);
fclose($outputFile);