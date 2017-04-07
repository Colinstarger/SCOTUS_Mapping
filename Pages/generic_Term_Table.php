<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-us">

<head>

<?php
require '../Libs/scotus_pages.php';
require '../Data/data_2014_Term.php';
require '../Data/data_2015_Term.php';
require '../Data/data_combined_14_15_Terms.php';
require '../Data/draft_16_Term.php';


//Change these variables 
$title = "2016 Term";
$class_var = "2016_term_class";
$collection_var = $term_2016;


//Now HTML
echo "<title>$title</title>";

include_Standard_Header_Term_Table ();

?>

</head>

<body>

<a name="Introduction"></a>
<?php include_Title_Term_Table($title, $class_var); ?>
	
<div id="main">

<?php 

include_Intro_Term_Table($title, $class_var); 
include_Page_Cross_Ref_Term_Table ($title, $class_var);
include_Full_Term_Table ($title, $class_var, $collection_var);
include_Stats_Term_Table ($title, $class_var, $collection_var);
include_Terminology_Method_Term_Table ($title, $class_var);
?> 

</div>
</body>
</html>