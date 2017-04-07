<?php 
$first_collection = new Network_Collection('first_collection');
$map = new CL_Network(255);
$map->add_term_collection_data('HEIEN v. NORTH CAROLINA', '2014-12-15', '4A - Mistake', 'http://www.scotusblog.com/case-files/cases/heien-v-north-carolina/', 'Brinegar', '1949-10-10', 61, 0.6, 11, 0.52);
$first_collection->add_network($map);
$map = new CL_Network(257);
$map->add_term_collection_data('HOLT v. HOBBS', '2015-01-20', 'RLUIPA- Beard', 'http://www.scotusblog.com/case-files/cases/holt-v-hobbs/', 'Thomas', '1981-04-06', 22, 0.36, 5, 0.3);
$first_collection->add_network($map);
$map = new CL_Network(458);
$map->add_term_collection_data('M&G POLYMERS USA v. TACKETT', '2015-01-26', 'ERISA - Contract', 'http://www.scotusblog.com/case-files/cases/mg-polymers-usa-llc-v-tackett/', 'Textile Workers', '1957-06-03', 15, 0.33, 3, 0.42);
$first_collection->add_network($map);
?>