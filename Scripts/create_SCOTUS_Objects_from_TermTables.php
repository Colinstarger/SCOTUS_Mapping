<?php	

	define("EOL", "\r\n", true);

//This function only needed for 2014
function convert_Heaader_Upper_to_Lower ($header)
{

	$all_caps_words = array("NC", "FTC", "USA", "ALA", "CSX", "UPS", "EEOC", "T", "EPA", "AZ", "M&amp;G", "BNB", "R.R.", "DOT", "TX");
	$no_caps_words = array ("of", "for", "the", "v.", "and");
	
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

	// This script will create PHP variables from the 2014 and 2015 Term HTML pages
	$sourcefile = "../Data/Homepage_2015_Term.html";
	$targetfile = "../Data/data_2015_Term.php";
	$collection_var_name = "term_2015"; //this will be your variable name
	$collection_name = "2015 Term";


	$file = fopen($sourcefile, "r") or die("Unable to open file $filename");
	
	$html=fread($file, filesize($sourcefile));
	fclose($file);
	
	# Create a DOM parser object
	$dom = new DOMDocument();
	@$dom->loadHTML($html);
	
	
	$file = fopen($targetfile, "w") or die("Unable to open file $filename");

	$filetext= "<?php ".EOL;
	fwrite($file, $filetext);

	$filetext = "\$$collection_var_name = new Network_Collection('$collection_name');".EOL;
	fwrite($file, $filetext);


	# Iterate over all the <td> tags
	foreach ($dom->getElementsByTagName('tr') as $row) {
			
		$td_tags = $row->getElementsByTagName('td');
		echo "Inside TR with " . $td_tags->length . " td elements \r\n";

		if ($td_tags->length == 10) {
			
			if (!($td_tags->item(9)->nodeValue=="n/a")) { //This is just to weed out the non-network cases in 2015
				$network_url = $td_tags->item(0)->getElementsByTagName('a')->item(0)->getAttribute('href');
				preg_match('/scotus-mapper\/([0-9]+)\//', $network_url, $matches, PREG_OFFSET_CAPTURE);
				$network_num = $matches[1][0];
			
				$blog_url = $td_tags->item(2)->getElementsByTagName('a')->item(0)->getAttribute('href');

				$new_anchor = htmlspecialchars($td_tags->item(0)->nodeValue);

				if ($collection_name == "2014 Term") {
					$new_anchor = convert_Heaader_Upper_to_Lower ($new_anchor);
				}
				$new_anchor_date = $td_tags->item(1)->nodeValue;
				$subject_area = htmlspecialchars($td_tags->item(2)->nodeValue);
				$old_anchor = htmlspecialchars($td_tags->item(3)->nodeValue);
				$old_anchor_date = $td_tags->item(4)->nodeValue;
				//Skip item (5) which is age - can be calculated
				$num_3d = $td_tags->item(6)->nodeValue;
				if ($num_3d=="tb"){$num_3d=-1;}
				$DOD_3d = $td_tags->item(7)->nodeValue;
				if ($DOD_3d=="tb"){$DOD_3d=-1;}
				$num_2d = $td_tags->item(8)->nodeValue;
				$DOD_2d = $td_tags->item(9)->nodeValue;

				$filetext = "\$map = new CL_Network($network_num);".EOL;
				fwrite($file, $filetext);

				$filetext = "\$map->add_term_collection_data(\"$new_anchor\", '$new_anchor_date', '$subject_area', '$blog_url', \"$old_anchor\",'$old_anchor_date', $num_3d, $DOD_3d, $num_2d, $DOD_2d);".EOL;
				fwrite($file, $filetext);

				$filetext = "\$$collection_var_name"."->add_network(\$map);".EOL;
				fwrite($file, $filetext);

			} // if nodeVale != "n/a" - to weed out certain 2015 cases

		} // if $td_tags
	} // foreach

	$filetext= "?>";
	fwrite($file, $filetext);

	fclose($file);
	
?>