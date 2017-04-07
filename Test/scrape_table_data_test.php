<?php

require '../Libs/scotus_objects.php';


$test_collection = new Network_Collection("My Test");

$test = new CL_Network(1065);
$test_collection->add_network($test);

//$test->scrape_table_data();
//$test->echo_network();



$test = new CL_Network(1067);
$test_collection->add_network($test);

$test = new CL_Network(1124);
$test_collection->add_network($test);


$test_collection->scrape_table_data_collection();
//$test_collection->echo_term_rows();
$test_collection->echo_collection();


?>