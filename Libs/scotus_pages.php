<?php

//functions to create SCOTUS Network Webpages

require 'scotus_objects.php';

function include_Tablesorter_css () {

	echo "<link rel='stylesheet' href='jquerytablesorterfile/docs/css/jq.css' type='text/css' media='print, projection, screen'/>";
	echo "<link rel='stylesheet' href='jquerytablesorterfile/themes/blue/style.css' type='text/css' media='print, projection, screen' />";

}

function include_Tablesorter_js () {
	echo "<script type='text/javascript' src='jquerytablesorterfile/jquery.tablesorter.js'></script>";

	echo "<script type='text/javascript'>";
	echo "$(function() {";		
	echo "$('#tablesorter-scotus').tablesorter({sortList:[[1,0]], widgets: ['zebra']});";
	echo "$('#options').tablesorter({sortList: [[1,0]], headers: { 3:{sorter: false}, 4:{sorter: false}}});";
	echo "});";	
	echo "</script>";

}

function include_JQuery_Bootstrap () {

	echo "<link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>";
	echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script>";

}

function include_Favicon ($type="three_dots") {

	if ($type=="three_dots") {
		
		echo "<![if !IE]>";
    	echo "<link rel='icon' href='http://home.ubalt.edu/id86mp66/Images/mapper_favicon.png' type='image/png' />";
    	echo "<![endif]>";
    	echo "<!-- This is needed for IE -->";
    	echo "<link rel='shortcut icon' href='home.ubalt.edu/id86mp66/Images/mapper_favicon.ico' type='image/ico' />";
	}
}

function include_Standard_Header_Term_Table () {

	include_Tablesorter_css();
	include_Favicon();
	include_JQuery_Bootstrap();
	
	include_Tablesorter_js();

}

function include_Title_Term_Table($title, $class_var) {

	echo "<div class='container'>";	
	echo "<div class='page-header $class_var'>";	
	echo "<h1 class='text-center'><span class='text-danger'>$title</span> 	SCOTUS Networks</h1>";      
	echo "</div>";
	echo "</div>";

}

function include_Intro_Term_Table($title, $class_var) {

	echo "<p class='$class_var'>";
	echo "This collection of $title Supreme Court citation networks was created with a <a class='external' href='https://courtlistener.com/visualizations/scotus-mapper/''>free online tool</a> available on <a class='external' href='https://courtlistener.com/visualizations/scotus-mapper/''>CourtListener</a>. Every case decided by the Court in the $title is in the table below with links to CourtListener network visualizations and <a href='http://www.scotusblog.com/''>SCOTUSBlog</a> entries. You can sort table data by column values including network age, number of network cases, and degree of dissent. Read more about our terminology and method below. This collection is part of the <a class='external' target='_blank' href='http://law.ubalt.libguides.com/scotuslib'>SCOTUS Map Library</a> developed by the <a class='external' href='http://law.ubalt.edu/faculty/scotus-mapping/index.cfm'>Supreme Court Mapping Project</a>."; 
	echo "</p>";
}

function include_Page_Cross_Ref_Term_Table ($title, $class_var) {

	echo "<p class='text-center $class_var'>";
	echo "<a href='#NetworkTerms'>Network Terminology</a> ~ <a href='#Method'>Method</a> ~  <a href='#TermStats'>$title Statistics</a> ~ <a href='#Collaborate'>Collaborate</a>";
	echo "</p>";
}

function include_Full_Term_Table ($title, $class_var, $collection_var) {

	echo"<table id='tablesorter-scotus' class='tablesorter $class_var' border='0' cellpadding='0' cellspacing='1'>
		<thead>
			<tr>
				<th>$title Case (link to CourtListener Visualization)</th>
				<th>Decided</th>
				<th>Law at Issue (link to SCOTUSBlog)</th>
				<th>Network Anchor</th>
				<th>Decided</th>
				<th>Network Age</th>
				<th>3D cases</th>
				<th>3D DOD</th>
				<th>2D cases</th>
				<th>2D DOD</th>
			</tr>
		</thead>
		
		<tbody>";

		
		$collection_var->echo_term_rows();
		

	echo "</tbody>
			</table>";

}

function include_Stats_Term_Table ($title, $class_var, $collection_var)
{
	echo "<a name='TermStats'></a>";
	echo "<div class = '$class_var'>";
	echo "<h3>$title Statistics</h3>";
	echo "<p>
	<ul>
		<li>Number of networks from 2015 Term: <strong>" . $collection_var->number_networks() . "</strong>. </li>
		
		<li>Average age of network:<strong>" . $collection_var->network_average_age_years() . " years</strong>. Median age of network:<strong>" . $collection_var->network_median_age_years() . " years</strong>.</li>
		<li>Average number of 3D cases:<strong>" . $collection_var->network_average_num_3D_cases() . "</strong>. Median number of 3D cases:<strong>" . $collection_var->network_median_num_3D_cases() . "</strong>.</li>
		<li>Average number of 2D cases:<strong>" . $collection_var->network_average_num_2D_cases() . "</strong>. Median number of 2D cases:<strong>". $collection_var->network_median_num_2D_cases() . "</strong>.</li>
		<li>Average 3D Degree of Dissent:<strong>" . $collection_var->network_average_3D_DOD() . "</strong>. Median 3D Degree of Dissent:<strong>" . $collection_var->network_median_3D_DOD() ."</strong>.</li>
		<li>Average 2D Degree of Dissent:<strong>" . $collection_var->network_average_2D_DOD() . "</strong>. Median 2D Degree of Dissent:<strong>" . $collection_var->network_median_2D_DOD() . "</strong>.</li>
	</ul>
	</p>
	</div>";

} 

function include_Terminology_Method_Term_Table ($title, $class_var){

echo "<div class = '$class_var'>";

echo "<a name='NetworkTerms'></a>
	<h3>Network Terminology</h3>
	<p>
		<ul>
			<li>Supreme Court citation networks show the citation connections between two Court cases. Every network connects two cases, the <strong>$title Case</strong> and the <strong>Network Anchor Case</strong>.</li>
			<li>The <strong>Network Age</strong> expresses the amount of time (in years) between the time the Anchor Case was decided and when the 2015 Term Case was decided.</li>
		  	<li>The <strong>\"D\"</strong> in <strong>\"3D\"</strong> and <strong>\"2D\"</strong> stands for \"degree of connection.\" Since the $title Case always cites the Network Anchor Case, those cases are 1-degree connected.</li> 
		  	<li>The <strong>2D cases</strong> column gives the number of 2-degree connections that exist between the $title Case and the Network Anchor Case - that is, how many cases exist in the network that are cited by the $title Case AND in turn cite the Network Anchor. For example, Case X would be a 2D case if the $title Case cited Case X and Case X in turn cited the Network Anchor Case. Please note that the 2D case number includes the two 1D cases (2015 Term Case + Network Anchor).</li>
		  	<li>The <strong>3D cases</strong> column gives the number of 3-degree connections that exist between the $title Case and the Network Anchor Case. 3D cases are those that are cited by a 2D case AND in turn cite the Network Anchor. Thus, Case Y would be a 3D case if Case X above Cited Y, which in turn cited the Network Anchor Case. Please note that the 3D case number includes the all the 2D+1D cases.</li>
		  	<li><strong>DOD</strong> stands for \"Degree of Dissent\". The DOD of an individual case is calculated based on its vote for outcome, as specified by<a class='external' href='http://scdb.wustl.edu/documentation.php?var=majVotes'> the Supreme Court Database (Spaeth)</a>. Since a 5-4 decision is the maximum amount of dissent possible in a SCOTUS case, it has a DOD of 1.0. Conversely, a 9-0 case has a DOD of 0. This means that an 8-1 decision has a 0.25 DOD, a 7-2 has a 0.50 DOD, and a 6-3 has a 0.75 DOD. To calculate DOD, the number of dissents is multiplied by 0.25 (thus a 6-2 case would still have a 0.50 DOD).</li>
		  	<li><strong>2D DOD</strong> is the average DOD for all the 2D cases. </li>
		  	<li><strong>3D DOD</strong> is the average DOD for all the 3D cases. </li>
		  	<li><strong>tb</strong> stands for \"too big\" and appears when a 3D network contains more than 70 cases. See <a href='#Method'>Method</a> below for further explanation.
			<li><a href='#Introduction'>RETURN TO TOP</a></li>
		</ul>
	</p>";

	echo "<a name='Method'></a>
	<h3>Method</h3>
	<p>
		Each network was created by the researcher using the <a class='external' href='https://courtlistener.com/visualizations/scotus-mapper/'>free tool on CourtListener</a>. Choice of the Network Anchor Case was based on a reading of the opinion and relevant SCOTUSBlog entry. The textual justification for the Network Anchor Case choice is provided in the visualization's \"Description\" field. Once an Anchor Case is chosen, the citation networks are generated automatically by the software.
	</p>
	<p>
		<strong>Limitations</strong>. Pleast note that the tool does not allow for citation networks with more than 70 cases in them. If a 3D network has more than 70 cases, the tool will return the 2D network only (in the table, \"tb\" will appear in the 3D column). Finally,since citations between cases are all parsed by computer, the tool does experience occasional data errors. The most common error is for the parser to fail to recognize non-standard cites to recent cases. 
	</p>";
		
	echo "<a name='Collaborate'></a>
	<h3>Contact</h3>
	<p>
		This collection of $title cases was created as part of the <a class='external' href='http://law.ubalt.edu/faculty/scotus-mapping/index.cfm'>Supreme Court Mapping Project</a>. We welcome feedback and will link <a class='external' href='https://courtlistener.com/visualizations/scotus-mapper/''>networks you create on CourtListener</a> to visualizations presented in this table. Reach us by <a href='mailto:cstarger@ubalt.edu?subject=Term%20%Table20Contact'>email.</a>
	</p>
	<p class='text-center'>
		<a href='#Introduction'>RETURN TO TOP</a></li>
	</p>";

	echo "</div>";


}

?>