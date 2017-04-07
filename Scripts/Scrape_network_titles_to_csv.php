<?php

// This Script pulls from the network.txt file, scrapes the title from numbered network and saves to csv file

/* Section 1 looks at network map file */
$filename="../Data/networkmaps.txt";

$myfile = fopen($filename, "r") or die("Unable to open file $filename");
echo "The title line of $filename is ".fgets($myfile);

//Now loop through and put data into an array
$map_data = array();
$i=0;

while($line= fgets($myfile)) {
  $map_data[$i] = rtrim($line);
  echo "Putting in item $i, which = " . $map_data[$i] ."\r\n";
  $i++;
}
fclose($myfile);


/* Section 2 Gets Titles - first define a function */
function get_network_title($url) {
 
	$fp = file_get_contents($url);
	if (!$fp) 
	    return null;
	$res = preg_match("/<title>(.*)<\/title>/siU", $fp, $title_matches);
	if (!$res) 
	    return null; 
	// Clean up title: remove EOL's and excessive whitespace.
	$title = preg_replace('/\s+/', ' ', $title_matches[1]);
	$title = trim($title);
	//Get rid of specific words
	$title = str_replace('Network Graph of ', "", $title);
	$title = substr($title, 0, strlen($title)-22);
 
 return $title;
}

$file = fopen('mydata.csv', 'w');

/*Now construct URL and get the titles */
foreach ($map_data as $map_number) {
	
	$map_url="https://www.courtlistener.com/visualizations/scotus-mapper/".$map_number."/slug";
	$map_title = get_network_title ($map_url);
	echo "Title for map $map_number is $map_title \r\n";

	$csv_line = array($map_number,$map_title);
	fputcsv($file, $csv_line);
}

fclose($file);




?>