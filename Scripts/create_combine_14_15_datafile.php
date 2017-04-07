<?php

require '../Libs/scotus_objects.php';
require '../Data/data_2014_Term.php';
require '../Data/data_2015_Term.php';


$combined_2014_2015 = combine_network_collections ("2014-15 Term", $term_2014, $term_2015);

$combined_2014_2015->echo_collection();

$combined_2014_2015->write_PHP_datafile("../Data/data_combined_14_15_Terms.php", "combined_2014_2015");

?>