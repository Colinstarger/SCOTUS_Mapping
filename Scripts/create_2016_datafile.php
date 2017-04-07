<?php

//This is the basic script to populate a datafile given a hard list of network numbers

require '../Libs/scotus_objects.php';

//Putting this in by hand for now.
$new_maps = array(1067, 1059, 1065, 1075, 1066, 1079, 1114, 1106, 1109, 1115, 1124);

$term_2016 = new Network_Collection("2016 Term");

foreach ($new_maps as $network_num) {
	$map = new CL_Network($network_num);
	$term_2016->add_network($map);
}

$term_2016->scrape_table_data_collection();

$term_2016->write_PHP_datafile("../Data/draft_16_Term.php", "term_2016");

?>