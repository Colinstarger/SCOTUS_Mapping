# SCOTUS_Mapping

This is a basic library to help build webpages connected to the Supreme Court Mapping Project. See http://law.ubalt.edu/faculty/scotus-mapping/index.cfm.

Right now, /Libs contains 
(1) a PHP object library for CL_Networks and collections of CL_Networks in Network_Collections. This is the file scotus_objects.php. CL_Networks and Collections contain functions to scrape data from other parts of this lib as well as from the web;
(2) a collection of PHP functions to help write webpages. This is the file scotus_pages.php.

Right now, /Data contains
A variety of collections of data for use in making webpages. Currently, there are 2014 Term and 2015 Term data sets. The html files are what is up on the web now. The PHP files use the new form that will be deployed soon. The 2016 is draft in PHP form only. 2016 Term is ongoing.

Right now, /Pages contains
Draft ways of making webpages. generic_Term_Table.php is the coolest one right now. It represents the future!

/Tests contain various test scripts
