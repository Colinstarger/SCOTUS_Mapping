<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-us">
<head>

<?php

require '../Libs/scotus_objects.php';
require '../Data/data_2014_Term.php';

?>
	<title>SCOTUS 2014 Term Networks</title>
	

	<link rel="stylesheet" href="jquerytablesorterfile/docs/css/jq.css" type="text/css" media="print, projection, screen" />
	<link rel="stylesheet" href="jquerytablesorterfile/themes/blue/style.css" type="text/css" media="print, projection, screen" />

    <!-- Hide this line for IE (needed for Firefox and others) -->
    <![if !IE]>
    <link rel="icon" href="http://home.ubalt.edu/id86mp66/Images/mapper_favicon.png" type="image/png" />
    <![endif]>
    <!-- This is needed for IE -->
    <link rel="shortcut icon" href="home.ubalt.edu/id86mp66/Images/mapper_favicon.ico" type="image/ico" />


	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script type="text/javascript" src="jquerytablesorterfile/jquery.tablesorter.js"></script>

	<script type="text/javascript">
	$(function() {		
		$("#tablesorter-scotus").tablesorter({sortList:[[1,0]], widgets: ['zebra']});
		$("#options").tablesorter({sortList: [[1,0]], headers: { 3:{sorter: false}, 4:{sorter: false}}});
	});	
	</script>
</head>

<body>

<a name="Introduction"></a>
<div class="container">
  <div class="page-header">
    <h1 class="text-center"><span class="text-danger">2014 Term</span> SCOTUS Networks</h1>      
  </div>
</div>

<div id="main">
		
	<p>
		This collection of 2014 Term Supreme Court citation networks was created with a <a class="external" href="https://courtlistener.com/visualizations/scotus-mapper/">free online tool</a> available on <a class="external" href="https://courtlistener.com/visualizations/scotus-mapper/">CourtListener</a>. Every case decided by the Court in its 2014 Term is in the table below with links to CourtListener network visualizations and <a href="http://www.scotusblog.com/case-files/terms/ot2014/">SCOTUSBlog</a> entries. You can sort table data by column values including network age, number of network cases, and degree of dissent. Read more about our terminology and method below. This collection is part of the <a class="external" target="_blank" href="http://law.ubalt.libguides.com/scotuslib">SCOTUS Map Library</a> developed by the <a class="external" href="http://law.ubalt.edu/faculty/scotus-mapping/index.cfm">Supreme Court Mapping Project</a>. 
	</p>
		
	<p class="text-center">
		<a href="#NetworkTerms">Network Terminology</a> ~ <a href="#Method">Method</a> ~  <a href="#TermStats">2014 Term Statistics</a> ~ <a href="#Collaborate">Collaborate</a>
	</p>
  	
	<a name="2014Data"></a>
	<h3>2014 Term Network Data</h3>

	<table id="tablesorter-scotus" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
		<thead>
			<tr>
				<th>2014 Term Case (link to CourtListener Visualization)</th>
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
		
		<tbody>

		<?php
			$term_2014->echo_term_rows();
		?>

		</tbody>
	</table>
	
	<!-- Putting in some spaces -->
	<br>

<!-- Network Terms, 2014 Term Stats, Method/Analysis, and Collaborate -->
	<a name="TermStats"></a>
	<h3>2014 Term Statistics</h3>
	<p>
	<ul>
		<li>Number of cases in 2014 Term: <strong><?php echo $term_2014->number_networks(); ?></strong>. This comes from the list of 2014 Term cases comes from the <a class="external" href="http://scdb.wustl.edu/analysisCaseListing.php?sid=1501-TEARDROP-3854">Supreme Court Database (Spaeth)</a>.</li>
		
		<li>Average age of network:<strong><?php echo $term_2014->network_average_age_years();?> years</strong>. Median age of network:<strong><?php echo $term_2014->network_median_age_years();?> years</strong>.</li>
		<li>Average number of 3D cases:<strong><?php echo $term_2014->network_average_num_3D_cases();?></strong>. Median number of 3D cases:<strong><?php echo $term_2014->network_median_num_3D_cases();?></strong>.</li>
		<li>Average number of 2D cases:<strong><?php echo $term_2014->network_average_num_2D_cases();?></strong>. Median number of 2D cases:<strong><?php echo $term_2014->network_median_num_2D_cases();?></strong>.</li>
		<li>Average 3D Degree of Dissent:<strong><?php echo $term_2014->network_average_3D_DOD();?></strong>. Median 3D Degree of Dissent:<strong><?php echo $term_2014->network_median_3D_DOD();?></strong>.</li>
		<li>Average 2D Degree of Dissent:<strong><?php echo $term_2014->network_average_2D_DOD();?></strong>. Median 2D Degree of Dissent:<strong><?php echo $term_2014->network_median_2D_DOD();?></strong>.</li>
	</ul>
	</p>


	<a name="NetworkTerms"></a>
	<h3>Network Terminology</h3>
	<p>
		<ul>
			<li>Supreme Court citation networks show the citation connections between two Court cases. Every network connects two cases, the <strong>2014 Term Case</strong> and the <strong>Network Anchor Case</strong>.</li>
			<li>The <strong>Network Age</strong> expresses the amount of time (in years) between the time the Anchor Case was decided and when the 2014 Term Case was decided.</li>
		  	<li>The <strong>"D"</strong> in <strong>"3D"</strong> and <strong>"2D"</strong> stands for "degree of connection." Since the 2014 Term Case always cites the Network Anchor Case, those cases are 1-degree connected.</li> 
		  	<li>The <strong>2D cases</strong> column gives the number of 2-degree connections that exist between the 2014 Term Case and the Network Anchor Case - that is, how many cases exist in the network that are cited by the 2014 Term Case AND in turn cite the Network Anchor. For example, Case X would be a 2D case if the 2014 Term Case cited Case X and Case X in turn cited the Network Anchor Case. Please note that the 2D case number includes the two 1D cases (2014 Term Case + Network Anchor).</li>
		  	<li>The <strong>3D cases</strong> column gives the number of 3-degree connections that exist between the 2014 Term Case and the Network Anchor Case. 3D cases are those that are cited by a 2D case AND in turn cite the Network Anchor. Thus, Case Y would be a 3D case if Case X above Cited Y, which in turn cited the Network Anchor Case. Please note that the 3D case number includes the all the 2D+1D cases.</li>
		  	<li><strong>DOD</strong> stands for "Degree of Dissent". The DOD of an individual case is calculated based on its vote for outcome, as specified by<a class="external" href="http://scdb.wustl.edu/documentation.php?var=majVotes"> the Supreme Court Database (Spaeth)</a>. Since a 5-4 decision is the maximum amount of dissent possible in a SCOTUS case, it has a DOD of 1.0. Conversely, a 9-0 case has a DOD of 0. This means that an 8-1 decision has a 0.25 DOD, a 7-2 has a 0.50 DOD, and a 6-3 has a 0.75 DOD. To calculate DOD, the number of dissents is multiplied by 0.25 (thus a 6-2 case would still have a 0.50 DOD).</li>
		  	<li><strong>2D DOD</strong> is the average DOD for all the 2D cases. </li>
		  	<li><strong>3D DOD</strong> is the average DOD for all the 3D cases. </li>
		  	<li><strong>tb</strong> stands for "too big" and appears when a 3D network contains more than 70 cases. See <a href="#Method">Method</a> below for further explanation.
			<li><a href="#Introduction">RETURN TO TOP</a></li>
		</ul>
	</p>

	<a name="Method"></a>
	<h3>Method</h3>
	<p>
		Each network was created by the researcher using the <a class="external" href="https://courtlistener.com/visualizations/scotus-mapper/">free tool on CourtListener</a>. Choice of the Network Anchor Case was based on a reading of the opinion and relevant SCOTUSBlog entry. The textual justification for the Network Anchor Case choice is provided in the visualization's "Description" field. Once an Anchor Case is chosen, the citation networks are generated automatically by the software.
	</p>
	<p>
		<strong>Limitations</strong>. Pleast note that the tool does not allow for citation networks with more than 70 cases in them. If a 3D network has more than 70 cases, the tool will return the 2D network only (in the table, "tb" will appear in the 3D column). Finally,since citations between cases are all parsed by computer, the tool does experience occasional data errors. The most common error is for the parser to fail to recognize non-standard cites to recent cases. 
	</p>
		
	<a name="Collaborate"></a>
	<h3>Contact</h3>
	<p>
		This collection of 2014 Term cases was created as part of the <a class="external" href="http://law.ubalt.edu/faculty/scotus-mapping/index.cfm">Supreme Court Mapping Project</a>. We welcome feedback and will link <a class="external" href="https://courtlistener.com/visualizations/scotus-mapper/">networks you create on CourtListener</a> to visualizations presented in this table. Reach us by <a href="mailto:cstarger@ubalt.edu?subject=2014%20Term%20Contact">email.</a>
	</p>
	<p class="text-center">
		<a href="#Introduction">RETURN TO TOP</a></li>
	</p>

</div>

</body>
</html>

