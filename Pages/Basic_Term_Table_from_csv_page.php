<!doctype html>

<!-- This is a basic HTML page that creates a Network list from a CSV file -->

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>2016 Term Basic</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Latest compiled and minified CSS  -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>


<body>
    <div class="container-fluid">

		<div class ="row"> 
			<div class="col-md-12">
				<h1>Filling Table from List</h1>
				<table>
					<tr>
						<th>Number</th>
						<th>Map Title</th>
					</tr>

					<?php	
						$filename = "../Data/mydata.csv";
						$file = fopen($filename, "r") or die("Unable to open file $filename");
					
						$x=1;

						while (($line = fgetcsv($file)) !== FALSE) {
					         $map = $line[0];
					         $url = 'https://www.courtlistener.com/visualizations/scotus-mapper/' . $map . "/slug";
					         $title = $line[1];
					         
					         echo "<tr><td>$x</td><td><a href=\"$url\">$title</a></td></tr>";
					         $x++;
					     }
					     
					    fclose($file);
					?>
				</table>

			</div>
		</div>

	</div>
</body>
</html>