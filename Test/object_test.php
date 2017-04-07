<?php

require '../Libs/scotus_objects.php';
require '../Data/data_2014_Term.php';
require '../Data/data_2015_Term.php';


function convert_Heaader_Upper_to_Lower ($header)
{

	$all_caps_words = array("NC", "FTC", "USA", "ALA", "CSX", "UPS", "EEOC", "T", "EPA", "AZ", "M&amp;G");
	$no_caps_words = array ("of", "for", "the", "v.");
	
	$keywords = preg_split("/[\s,]+/", $header);

	$new_header="";

	foreach ($keywords as $value) {
		$new_value= $value;

		if (!in_array($value, $all_caps_words)) {
	
			$new_value=strtolower($new_value);
	
			if (!in_array($new_value, $no_caps_words))
			$new_value=ucfirst($new_value);
		}
		$new_header = $new_header . $new_value . " ";
	}

	$new_header = rtrim($new_header);

	return ($new_header);
}

	$combined_2014_2015 = combine_network_collections ("Colin's new collection", $term_2014, $term_2015);

	echo ("Drum roll please... the combined collection is... ").EOL;
	$combined_2014_2015->echo_collection();
?>